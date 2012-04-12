<?php
/**
 * Copyright (c) 2012, Zachary Schuessler <zschuessler@deltasys.com>
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without 
 * modification, are permitted provided that the following conditions are met:
 * 
 * - Redistributions of source code must retain the above copyright notice, 
 *   this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice, 
 *   this list of conditions and the following disclaimer in the documentation 
 *   and/or other materials provided with the distribution.
 * - Neither the name of Brad Griffith nor the names of other contributors may 
 *   be used to endorse or promote products derived from this software without
 *   specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE 
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF 
 * THE POSSIBILITY OF SUCH DAMAGE.
 */

class Zaclee_QuarkBar_Block_Quarkbar extends Mage_Core_Block_Template
{

    /**
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
        if(!$this->_quarkSession->isAdmin()) {
            return;
        }
        
        $this->setTemplate('quarkbar/quarkbar.phtml');
    }

    protected function _toHtml()
    {
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
        if(!$this->_quarkSession->isAdmin()) {
            return;
        }
        
        /**
         * Check for the head block, since the Magento installer
         * does not have this block and will error out. 
         */
        if ($this->getLayout()->getBlock('head')) {
            $this->getLayout()->getBlock('head')
                    ->addJs('quarkbar/jquery/jquery-1.7.2.min.js')
                    ->addJs('quarkbar/bootstrap/js/bootstrap.js')
                    ->addJs('quarkbar/quark.js')
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
        
        $identifier = Mage::getModel('core/cookie')->get('quark_bar');
        $salt       = $this->_quarkSession->getSaltByIdentifier($identifier);

        if (Mage::registry('current_product')) {
            $secret = 'catalog_product' . 'edit' . $salt;
            $key    = Mage::helper('core')->getHash($secret);

            $product = Mage::getModel('catalog/product')
                    ->load(Mage::app()->getRequest()->getParam('id'));

            return sprintf('<li><a href="/admin/catalog_product/edit/id/%s/key/%s">Edit %s ..</a></li>', $product->getId(), $key, $this->htmlEscape(substr($product->getName(), 0, 20))
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
    
    public function getUser()
    {
        $identifier = Mage::getModel('core/cookie')->get('quark_bar');
        $row = $this->_quarkSession->getUserByIdentifier($identifier);
        return $row['user'];
    }

}