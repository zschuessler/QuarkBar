<?php

class Zaclee_QuarkBar_Model_PredispatchObserver
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
            if ($this->_authorizedAdmin()) {
                $this->_showFrontendBar();
            }
        }

        echo '</div>';

        echo '<div class="clear">&nbsp;</div>';
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

    /**
     * Shows the QuarkBar for administrator module 
     */
    protected function _showAdminBar()
    {
        echo 'admin';
    }

    /**
     * Shows the QuarkBar for frontend store 
     */
    protected function _showFrontendBar()
    {
        echo Mage::app()->getLayout()
                        ->createBlock('quarkbar/frontbar')
                        ->toHtml();
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