<?php

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
        
        if( isset($quarkCookie) ) {
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
        if( !$identifier ) {
            Mage::log('Null identifier when calling getSaltByIdentifier()');
            return false;
        }
        
        $quarkSession = $this->getCollection()
                             ->addFieldToFilter('identifier', $identifier)
                             ->getData();
        
        if( isset($quarkSession[0]['salt'])) {
            return $quarkSession[0]['salt'];
        }
       
        return false;
    }
}