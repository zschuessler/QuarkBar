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

}