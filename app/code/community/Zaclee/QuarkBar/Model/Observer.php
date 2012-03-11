<?php

class Zaclee_QuarkBar_Model_Observer
{
    public function controller_action_predispatch($event)
    {
        $controller = $event->getController();
        
        Zend_Debug::dump($event);exit;
    }
}