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

class Zaclee_QuarkBar_Model_Session extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('quarkbar/session');
    }

    /**
     * Checks that the user is an administrator with a valid session.
     * 
     * @return bool
     */
    public function isAdmin()
    {
        $quarkCookie = Mage::getModel('core/cookie')->get('quark_bar');

        $quarkSession = $this->getCollection()
                ->addFieldToFilter('identifier', $quarkCookie)
                ->getData();

        if (count($quarkSession)) {
            return true;
        }

        return false;
    }

    /**
     * Gets salt for a specific session when supplied
     * with the session identifier
     * 
     * @param string
     * @return string
     */
    public function getSaltByIdentifier($identifier)
    {
        if (!$identifier) {
            Mage::log('Null identifier when calling getSaltByIdentifier()');
            return false;
        }

        $quarkSession = $this->getCollection()
                ->addFieldToFilter('identifier', $identifier)
                ->getData();

        if (isset($quarkSession[0]['salt'])) {
            return $quarkSession[0]['salt'];
        }

        return false;
    }

    /**
     * Gets the session by admin username 
     */
    public function getSessionByAdmin($username)
    {
        $quarkSession = $this->getCollection()
                ->addFieldToFilter('user', $username)
                ->getData();

        if (count($quarkSession)) {
            return $quarkSession[0];
        }

        return false;
    }

    /**
     * Returns the current user that owns the session 
     * 
     * @return Array $row
     */
    public function getUserByIdentifier($id)
    {
        $quarkSession = $this->getCollection()
                ->addFieldToFilter('identifier', $id)
                ->getData();

        if (count($quarkSession)) {
            return $quarkSession[0];
        }

        return false;
    }

    /**
     * Removes a session by identifier
     * 
     * @param string $identifier 
     */
    public function removeSessionByIdentifier($id)
    {
        $quarkSession = $this->getCollection()
                ->addFieldToFilter('identifier', $id);

        if (count($quarkSession)) {
            foreach ($quarkSession as $session) {
                $session->delete();
            }
        }

        return false;
    }

    /**
     * Clears sessions with a specific username
     * 
     * @param string $username 
     */
    public function clearSessionsByUser($username)
    {
        $quarkSession = $this->getCollection()
                ->addFieldToFilter('user', $username);

        if (count($quarkSession)) {
            foreach ($quarkSession as $session) {
                $session->delete();
            }
        }

        return false;
    }

}