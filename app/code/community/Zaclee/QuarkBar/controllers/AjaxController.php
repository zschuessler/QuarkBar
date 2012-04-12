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

class Zaclee_QuarkBar_AjaxController extends Mage_Core_Controller_Front_Action
{

    /**
     * A message to be returned in JSON
     * @var string 
     */
    var $_message;

    /**
     * A code to indicate success or an error message.
     * 
     * 0 = Error
     * 1 = Success
     * 2 = Warning
     * 
     * @var int 
     */
    var $_code;
    
    public function preDispatch()
    {
        $request = Mage::app()->getRequest();
        
        if(!$request->isAjax()) {
            //Mage::throwException('You may not access this page.');
        }
    }

    /**
     * Clears cache and redirects to previous URL. 
     * 
     * @return string
     */
    public function clearCacheAction()
    {
        try {
            Mage::app()->getCache()->clean();
            $this->_code = 1;
            $this->_message = 'Cache cleaned successfully.';
        } catch (Exception $e) {
            $this->_code = 0;
            $this->_message = $e->getMessage();
        }

        echo json_encode(array('status'  => $this->_code, 'message' => $this->_message));
    }

    /**
     * Rebuilds all Magento indexes 
     */
    public function rebuildIndexesAction()
    {
        try {
            $processes = Mage::getSingleton('index/indexer')->getProcessesCollection();
            $processes->walk('reindexAll');
            
            $this->_code = 1;
            $this->_message = 'Indexes rebuilt successfully.';
        } catch (Exception $e) {
            $this->_code = 0;
            $this->_message = $e->getMessage();
        }
        
        echo json_encode(array('status'  => $this->_code, 'message' => $this->_message));
    }
    
    /**
     * Logs current user out 
     */
    public function logoutAction()
    {
        $quarkSession = Mage::getModel('quarkbar/session');

        try {
            $identifier = Mage::getModel('core/cookie')->get('quark_bar');
            $quarkSession->removeSessionByIdentifier($identifier);
            
            Mage::getModel('core/cookie')->delete('quark_bar');
            
            $this->_code = 1;
            $this->_message = 'Logged out successfully.';
        } catch (Exception $e) {
            $this->_code = 0;
            $this->_message = $e->getMessage();
        }
        
        echo json_encode(array('status'  => $this->_code, 'message' => $this->_message));
    }

}