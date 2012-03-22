<?php

class Zaclee_QuarkBar_Block_Frontbar extends Mage_Core_Block_Template
{

    protected function _toHtml()
    {
        $request = $this->getRequest();

        echo $this->_buildNavbar();
    }

    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('head')->addJs('quarkbar/jquery/jquery-1.7.2.min.js')
                                            ->addJs('quarkbar/bootstrap/js/bootstrap.js')
                                            ->addCss('quarkbar/bootstrap/css/bootstrap.min.css');
    }

    protected function _buildNavbar()
    {
        return sprintf('
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                    <a class="brand" href="#">
                        %s
                    </a>
                    <ul class="nav">
                        <li class="active">
                            <a href="/admin">Admin</a>
                        </li>
                        
<li class="dropdown">
    <a href="#"
          class="dropdown-toggle"
          data-toggle="dropdown">
          Account
          <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
      <li>test</li>
    </ul>
                    </ul>
                    </div>
                </div>
             </div>',
            Mage::app()->getStore()->getName()
                );
    }

}