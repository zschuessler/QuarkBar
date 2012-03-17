<?php

class Zaclee_QuarkBar_Model_AdminLoginSuccessObserver
{

    public function admin_session_user_login_success($event)
    {
        $admin = $event->getEvent()->getUser();

        Mage::getModel('core/cookie')->set('quark_bar', 'admin');
    }

}