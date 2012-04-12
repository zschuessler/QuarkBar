<?php

class Zaclee_QuarkBar_AjaxController extends Mage_Core_Controller_Front_Action
{

    /**
     * A message to be returned in JSON
     * @var string 
     */
    var $_message;

    /**
     * A code to indicate success or an error message.
     * 
     * 0 = Error
     * 1 = Success
     * 2 = Warning
     * 
     * @var int 
     */
    var $_code;
    
    public function preDispatch()
    {
        $request = Mage::app()->getRequest();
        
        if(!$request->isAjax()) {
            //Mage::throwException('You may not access this page.');
        }
    }

    /**
     * Clears cache and redirects to previous URL. 
     * 
     * @return string
     */
    public function clearCacheAction()
    {
        try {
            Mage::app()->getCache()->clean();
            $this->_code = 1;
            $this->_message = 'Cache cleaned successfully.';
        } catch (Exception $e) {
            $this->_code = 0;
            $this->_message = $e->getMessage();
        }

        echo json_encode(array('status'  => $this->_code, 'message' => $this->_message));
    }

    /**
     * Rebuilds all Magento indexes 
     */
    public function rebuildIndexesAction()
    {
        try {
            $processes = Mage::getSingleton('index/indexer')->getProcessesCollection();
            $processes->walk('reindexAll');
            
            $this->_code = 1;
            $this->_message = 'Indexes rebuilt successfully.';
        } catch (Exception $e) {
            $this->_code = 0;
            $this->_message = $e->getMessage();
        }
        
        echo json_encode(array('status'  => $this->_code, 'message' => $this->_message));
    }
    
    /**
     * Logs current user out 
     */
    public function logoutAction()
    {
        $quarkSession = Mage::getModel('quarkbar/session');

        try {
            $identifier = Mage::getModel('core/cookie')->get('quark_bar');
            $quarkSession->removeSessionByIdentifier($identifier);
            
            Mage::getModel('core/cookie')->delete('quark_bar');
            
            $this->_code = 1;
            $this->_message = 'Logged out successfully.';
        } catch (Exception $e) {
            $this->_code = 0;
            $this->_message = $e->getMessage();
        }
        
        echo json_encode(array('status'  => $this->_code, 'message' => $this->_message));
    }

}