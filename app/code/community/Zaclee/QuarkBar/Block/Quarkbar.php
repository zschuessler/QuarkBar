<?php

class Zaclee_QuarkBar_Block_Quarkbar extends Mage_Core_Block_Template
{

    /**
     * The quark_session model
     * @var Zaclee_QuarkBar_Model_Session 
     */
    protected $_quarkSession;

    /**
     * Path to template file in theme.
     *
     * @var string
     */
    protected $_template = 'quarkbar/quarkbar.phtml';

    public function _construct()
    {
        parent::_construct();
        $this->_quarkSession = Mage::getModel('quarkbar/session');
        $this->setTemplate('quarkbar/quarkbar.phtml');
    }

    protected function _toHtml()
    {
        echo $this->getArea();
        $html = $this->renderView();

        return $html;
    }
    
    /**
     * Always set area as frontend, so we can use a single
     * template instead of two for both frontend and admin areas.
     * 
     * @return string
     */
    public function getArea()
    {
        return 'frontend';
    }

    protected function _prepareLayout()
    {
        /**
         * Check for the head block, since the Magento installer
         * does not have this block and will error out. 
         */
        if ($this->getLayout()->getBlock('head')) {
            $this->getLayout()->getBlock('head')
                    ->addJs('quarkbar/jquery/jquery-1.7.2.min.js')
                    ->addJs('quarkbar/bootstrap/js/bootstrap.js')
                    ->addJs('quarkbar/quark.js')
                    ->addCss('quarkbar/bootstrap/css/bootstrap.min.css')
                    ->addCss('quarkbar/css/styles.css');
        }
    }

    /**
     * Shows an admin link or a store link to easily switch between
     * frontend/admin modules
     * 
     * @return string 
     */
    public function getDashboardLink()
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
    public function getPageEditLink()
    {
        // Edit links are only useful for the frontend module
        if ('admin' == Mage::app()->getRequest()->getModuleName()) {
            return;
        }

        $salt = $this->_quarkSession->getSaltByIdentifier('admin!');

        if (Mage::registry('current_product')) {
            $secret = 'catalog_product' . 'edit' . $salt;
            $key    = Mage::helper('core')->getHash($secret);

            $product = Mage::getModel('catalog/product')
                    ->load(Mage::app()->getRequest()->getParam('id'));

            return sprintf('<li><a href="/admin/catalog_product/edit/id/%s/key/%s">Edit %s</a></li>', $product->getId(), $key, $this->htmlEscape($product->getName())
            );
        }

        if (Mage::registry('current_category')) {
            $secret = 'catalog_category' . 'index' . $salt;
            $key    = Mage::helper('core')->getHash($secret);

            return sprintf('<li><a href="/admin/catalog_category/index/key/%s">Edit Categories</a></li>', $key
            );
        }

        return;
    }

}