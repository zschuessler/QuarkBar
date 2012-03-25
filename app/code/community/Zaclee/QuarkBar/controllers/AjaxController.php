<?php

class Zaclee_QuarkBar_AjaxController extends Mage_Core_Controller_Front_Action
{
    /**
     * A message to be returned in JSON
     * @var string 
     */
    var $_message;
    
    /**
     * Clears cache and redirects to previous URL. 
     */
    public function clearCacheAction()
    {
        try {
            Mage::app()->getCache()->clean();
            $this->_message = 'Cache cleaned successfully.';
        } catch (Exception $e) {
            $this->_message = $e->getMessage();
        }
        
        echo json_encode($this->_message);
    }

}