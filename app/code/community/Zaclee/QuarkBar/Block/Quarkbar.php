<?php

class Zaclee_QuarkBar_Block_Quarkbar extends Mage_Core_Block_Template
{
    /**
     * The quark_session model
     * @var Zaclee_QuarkBar_Model_Session 
     */
    protected $_quarkSession;
    
    public function _construct()
    {
        parent::_construct();
        $this->_quarkSession = Mage::getModel('quarkbar/session');
    }
    
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
                        
                        %s
                        
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
             </div>
             <div style="clear:both;height:40px;"></div>',
                Mage::app()->getStore()->getName(),
                $this->_getDashboardLink(),
                $this->_getPageEditLink()
        );
    }

    /**
     * Shows an admin link or a store link to easily switch between
     * frontend/admin modules
     * 
     * @return string 
     */
    protected function _getDashboardLink()
    {
        if ('admin' == Mage::app()->getRequest()->getModuleName()) {
            return '<a href="/">View Frontend</a>';
        } else {
            return '<a href="/admin">Admin Dashboard</a>';
        }
    }

    /**
     * Supplies an edit link if a category or product page
     * 
     * @return string 
     */
    protected function _getPageEditLink()
    {
        // Edit links are only useful for the frontend module
        if('admin' == Mage::app()->getRequest()->getModuleName() ) {
            return;
        }
        
        $salt = $this->_quarkSession->getSaltByIdentifier('admin!');
        
        if (Mage::registry('current_product')) {
            $secret = 'catalog_product' . 'edit' . $salt;
            $key = Mage::helper('core')->getHash($secret);
            
            $product = Mage::getModel('catalog/product')
               ->load(Mage::app()->getRequest()->getParam('id'));
            
            return sprintf('<li><a href="/admin/catalog_product/edit/id/%s/key/%s">Edit %s</a></li>',
                    $product->getId(),
                    $key,
                    $this->htmlEscape($product->getName())
                    );
        }
        
        if(Mage::registry('current_category')) {
            $secret = 'catalog_category' . 'index' . $salt;
            $key = Mage::helper('core')->getHash($secret);
            
            return sprintf('<li><a href="/admin/catalog_category/index/key/%s">Edit Categories</a></li>',
                    $key
                    );
            
        }
        
        return;
    }

}