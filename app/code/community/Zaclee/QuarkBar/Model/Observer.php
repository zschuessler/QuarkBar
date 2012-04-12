<?php
/**
 * Copyright (c) 2012, Zachary Schuessler <zschuessler@deltasys.com>
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without 
 * modification, are permitted provided that the following conditions are met:
 * 
 * - Redistributions of source code must retain the above copyright notice, 
 *   this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice, 
 *   this list of conditions and the following disclaimer in the documentation 
 *   and/or other materials provided with the distribution.
 * - Neither the name of Brad Griffith nor the names of other contributors may 
 *   be used to endorse or promote products derived from this software without
 *   specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE 
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF 
 * THE POSSIBILITY OF SUCH DAMAGE.
 */

class Zaclee_QuarkBar_Model_Observer
{

    protected $_isLoaded;

    /**
     * Create the QuarkBar block after the layout blocks are generated
     */
    public function controller_action_layout_generate_blocks_after($event)
    {
        $request = Mage::app()->getRequest();
        $quarkSession = Mage::getModel('quarkbar/session');
        
        // Don't show a toolbar for ajax requests
        if ($request->isAjax()) {
            return;
        }
        
        // Show QuarkBar block
        if ($quarkSession->isAdmin()) {
            echo Mage::app()->getLayout()
                    ->createBlock('quarkbar/quarkbar')
                    ->toHtml();
        }
    }
    
    /**
     * After admin successfully logs in, create a session
     * for QuarkBar and store the salt
     */
    public function admin_session_user_login_success($event)
    {
        // Set salt that only the core session has access to
        $quarkSession = Mage::getModel('quarkbar/session');
        $salt = Mage::getSingleton('core/session')->getFormKey();
        if( isset($salt) ) {
            $quarkSession->setSalt($salt);
        }
        
        // Set user
        $quarkSession->clearSessionsByUser($event->getUser()->getUsername());
        $quarkSession->setUser($event->getUser()->getUsername());
        
        // Hash the random data to get a predictable format and length
        $hash = hash('sha256', openssl_random_pseudo_bytes(1024, $cryptoStrong));
        if($cryptoStrong) {
            $quarkSession->setIdentifier($hash); 
            $quarkSession->save();
            
            Mage::getModel('core/cookie')->set('quark_bar', $hash);
        } else {
            Mage::throwException('Unable to create secure crypt key.');
        }
    }
}