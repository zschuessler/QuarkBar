<?php

class Zaclee_QuarkBar_Model_AdminLoginSuccessObserver
{

    public function admin_session_user_login_success($event)
    {
        $admin = $event->getEvent();

        $customer = Mage::getModel('customer/customer');
        $customer->setWebsiteId(1);
        $customer->loadByEmail($admin->getEmail());
        
        // todo: login via curl?
    }

}