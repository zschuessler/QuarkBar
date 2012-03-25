<?php

class Zaclee_QuarkBar_Model_Observer
{

    protected $_isLoaded;

    public function controller_action_layout_generate_blocks_after($event)
    {
        $request = Mage::app()->getRequest();

        // Don't show a toolbar for ajax requests
        if ($request->isAjax()) {
            return;
        }

        // Show QuarkBar

        if ($this->_authorizedAdmin()) {
            echo Mage::app()->getLayout()
                    ->createBlock('quarkbar/quarkbar')
                    ->toHtml();
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