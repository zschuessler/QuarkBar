<?php

class Zaclee_QuarkBar_Model_Observer
{

    protected $_isLoaded;

    /**
     * Create the QuarkBar block after the layout blocks are generated
     */
    public function controller_action_layout_generate_blocks_after($event)
    {
        $request = Mage::app()->getRequest();

        // Don't show a toolbar for ajax requests
        if ($request->isAjax()) {
            return;
        }
        
        // Show QuarkBar block
        if ($this->_authorizedAdmin()) {
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
        // Admin flag
        Mage::getModel('core/cookie')->set('quark_bar', 'admin');
        
        // Set salt that only the core session has access to
        $quarkSession = Mage::getModel('quarkbar/session');
        $salt = Mage::getSingleton('core/session')->getFormKey();
        
        if( isset($salt) ) {
            $quarkSession->setSalt($salt);
        }
        // Hash the random data to get a predictable format and length
        $hash = hash('sha256', openssl_random_pseudo_bytes(1024, $cryptoStrong));
        
        if($cryptoStrong) {
            $quarkSession->setIdentifier($hash); 
            $quarkSession->save();
        } else {
            Mage::log('Unable to create secure crypt key.');
        }
    }

    /**
     * Checks if the current request is from the admin module.
     * 
     * @return bool 
     */
    protected function _isAdminModule()
    {
        if ('admin' == Mage::app()->getRequest()->getModuleName()) {
            return true;
        }

        return false;
    }

    public function _authorizedAdmin()
    {
        $auth = Mage::getModel('core/cookie')->get('quark_bar');

        if ($auth == 'admin') {
            return true;
        }

        return false;
    }

}