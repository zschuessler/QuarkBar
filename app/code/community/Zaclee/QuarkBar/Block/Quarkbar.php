<?php

class Zaclee_QuarkBar_Block_Quarkbar extends Mage_Core_Block_Template
{

    protected function _toHtml()
    {
        echo $this->_buildNavbar();
    }

    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('head')
                ->addJs('quarkbar/jquery/jquery-1.7.2.min.js')
                ->addJs('quarkbar/bootstrap/js/bootstrap.js')
                ->addJs('quarkbar/quark.js')
                ->addCss('quarkbar/bootstrap/css/bootstrap.min.css')
                ->addCss('quarkbar/css/styles.css');
    }

    protected function _buildNavbar()
    {
        return sprintf('
            <div id="quark-navbar" class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                    <a class="brand" href="/">
                        %s
                    </a>
                    <ul class="nav">
                        <li>
                            %s
                        </li>
                        
                        <li class="dropdown">
                            <a href="#"
                                class="dropdown-toggle"
                                data-toggle="dropdown">
                                Developer
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-header">Cache / Indexes</li>
                                <li class="divider"></li>
                                <li id="quark-clear-cache">
                                    <a href="#">Clear Cache</a>
                                </li>
                                <li id="quark-rebuild-indexes">
                                    <a href="#">Rebuild Indexes</a>
                                </li>
                                <li class="divider"></li>
                            </ul>
                        </li>
                    </ul>
                    </div>
                </div>
                <div id="quark-nav-status" class="alert fade in"></div>
             </div>',
        Mage::app()->getStore()->getName(),
        $this->_getDashboardLink()
        );
    }

    protected function _getDashboardLink()
    {
        if ('admin' == Mage::app()->getRequest()->getModuleName()) {
            return '<a href="/">View Frontend</a>';
        } else {
            return '<a href="/admin">Admin Dashboard</a>';
        }
    }

}