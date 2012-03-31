<?php

class Zaclee_QuarkBar_Model_Mysql4_Session extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('quarkbar/session', 'quarkbar_session_id');
    }
}