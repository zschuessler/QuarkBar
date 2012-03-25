<?php

class Zaclee_QuarkBar_Model_AdminLoginSuccessObserver
{

    public function admin_session_user_login_success($event)
    {
        // Admin flag
        Mage::getModel('core/cookie')->set('quark_bar', 'admin');
        
        // Set salt that only the core session has access to
        Mage::getModel('core/cookie')->set('quark_bar_salt', Mage::getSingleton('core/session')->getFormKey());
    }

}