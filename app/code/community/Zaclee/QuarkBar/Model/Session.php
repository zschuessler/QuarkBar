<?php

class Zaclee_QuarBar_Model_Session extends Mage_Core_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('quarkbar/session');
    }
}