<?php

$installer = $this;
$installer->startSetup();

// DELETE FROM core_resource WHERE code = 'quarkbar_setup';

$installer->run("
    DELETE FROM customer_group WHERE customer_group_code = 'admin';
    TRUNCATE customer_entity;"
);

/**
 *  Create admin customer group 
 */
// Find the first tax class for customers so
//  we can use it in creating the customer group.
$taxClasses = Mage::getModel('tax/class')->getCollection();
$taxClasses->addFieldToFilter('class_type', array(
    'like' => '%CUSTOMER%'
));

$taxClass   = $taxClasses->getFirstItem();
$taxClassId = $taxClass->getId();

// Add a new customer group 'admin'
$customerGroup = Mage::getModel('customer/group');
$customerGroup->setData(array(
    'customer_group_code' => 'admin',
    'tax_class_id'        => $taxClassId
));
$customerGroup->save();

// Duplicate admin user as a customer
$admins = Mage::getModel('admin/user')->getCollection();

foreach ($admins as $admin) {
    $customer = Mage::getModel('customer/customer');

    $customer->setWebsiteId(Mage::app()->getWebsite()->getId())
            ->setEmail($admin->getEmail())
            ->setFirstname($admin->getFirstname())
            ->setLastname($admin->getLastname())
            ->setPassword($admin->getPassword());

    $customer->save();
}
