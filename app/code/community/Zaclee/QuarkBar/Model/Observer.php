<?php

class Zaclee_QuarkBar_Model_Observer
{
    public function controller_action_predispatch($observer)
    {
        $controller = $event->getController();
        
        echo 'yup';exit;
    }
}