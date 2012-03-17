<?php

class Zaclee_QuarkBar_Block_Frontbar extends Mage_Core_Block_Template
{
    protected function _toHtml()
    {
       $request = $this->getRequest();
       
       $module = $request->getModuleName();
       $layout = $this->getLayout()->getBlockSingleton('root');
       Zend_Debug::dump($layout);exit;
       
       return sprintf('%s <br/> %s',
                      $module,
                      $layout);
    }
}