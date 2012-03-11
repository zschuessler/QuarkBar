<?php

class Zaclee_QuarkBar_Model_Observer
{
    public function controller_action_predispatch($event)
    {
        $controller = $event->getController();
        
        echo '
            <div class="quarkBar">test</div>
            <div class="quarkBar-clear">&nbsp;</div>
';
    }
}