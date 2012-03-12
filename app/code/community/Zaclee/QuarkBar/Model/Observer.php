<?php

class Zaclee_QuarkBar_Model_Observer
{

    protected $_isLoaded;

    public function controller_action_predispatch($event)
    {
        $request = Mage::app()->getRequest();
        
        // Don't show a toolbar for ajax requests
        if ($request->isAjax()) {
            return;
        }

        // Show QuarkBar
        echo '<div class="quarkBar">';

        if ($this->_isAdminModule()) {
            $this->_showAdminBar();
        } else {
            $this->_showFrontendBar();
        }

        echo '</div>';

        echo '<div class="clear">&nbsp;</div>';
    }

    /**
     * Checks if the current request is from the admin module.
     * 
     * @return bool 
     */
    public function _isAdminModule()
    {
        if ('admin' == Mage::app()->getRequest()->getModuleName()) {
            return true;
        }

        return false;
    }

    /**
     * Shows the QuarkBar for administrator module 
     */
    public function _showAdminBar()
    {
        echo 'admin';
    }

    /**
     * Shows the QuarkBar for frontend store 
     */
    public function _showFrontendBar()
    {
        echo 'frontend';
    }

}