<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

use Magento\Catalog\Api\Data\ProductExtensionInterfaceFactory;
use Magento\Catalog\Api\Data\ProductTierPriceExtensionFactory;

/** @var \Magento\Catalog\Api\ProductRepositoryInterface $productRepository */
// simple product without custom options
$secondProductSku = 'simple-multiselect';

/** @var \Magento\TestFramework\ObjectManager $objectManager */
$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

$installer = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
    \Magento\Catalog\Setup\CategorySetup::class
);

$productExtensionAttributesFactory = $objectManager->get(ProductExtensionInterfaceFactory::class);

$adminWebsite = $objectManager->get(\Magento\Store\Api\WebsiteRepositoryInterface::class)->get('admin');
/** @var  $tpExtensionAttributes */
$tpExtensionAttributesFactory = $objectManager->get(ProductTierPriceExtensionFactory::class);
$tierPriceExtensionAttributes1 = $tpExtensionAttributesFactory->create()
    ->setWebsiteId($adminWebsite->getId());
$productExtensionAttributesWebsiteIds = $productExtensionAttributesFactory->create(
    ['website_ids' => $adminWebsite->getId()]
);
/** @var \Magento\Catalog\Api\CategoryLinkManagementInterface $categoryLinkManagement */
$categoryLinkManagement = $objectManager->get(\Magento\Catalog\Api\CategoryLinkManagementInterface::class);
/** @var $productMultiselect \Magento\Catalog\Model\Product */
$productMultiselect = $objectManager->create(\Magento\Catalog\Model\Product::class);
$productMultiselect->isObjectNew(true);
$productMultiselect->setTypeId(\Magento\Catalog\Model\Product\Type::TYPE_SIMPLE)
    ->setId(22)
    ->setAttributeSetId(4)
    ->setWebsiteIds([1])
    ->setName('Simple Multiselect')
    ->setSku($secondProductSku)
    ->setPrice(11)
    ->setWeight(1)
    ->setShortDescription("Short description 2")
    ->setTaxClassId(0)
    ->setDescription('Description with <b>html tag</b>')
    ->setExtensionAttributes($productExtensionAttributesWebsiteIds)
    ->setMetaTitle('meta title 2')
    ->setMetaKeyword('meta keyword 2')
    ->setMetaDescription('meta description 2')
    ->setVisibility(\Magento\Catalog\Model\Product\Visibility::VISIBILITY_BOTH)
    ->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
    ->setStockData(
        [
            'use_config_manage_stock'   => 1,
            'qty'                       => 100,
            'is_qty_decimal'            => 0,
            'is_in_stock'               => 1,
        ]
    )->setCanSaveCustomOptions(false)
    ->setHasOptions(false);

$entityType = $installer->getEntityTypeId('catalog_product');
/** @var $attribute \Magento\Catalog\Model\ResourceModel\Eav\Attribute */
$attribute = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
    \Magento\Catalog\Model\ResourceModel\Eav\Attribute::class
)->loadByCode($entityType, 'multiselect_attribute_with_many_options');
/* todo: add options to the product before save */

/** @var \Magento\Catalog\Api\ProductRepositoryInterface $productRepository */
$productRepository = $objectManager->create(\Magento\Catalog\Api\ProductRepositoryInterface::class);
$productRepository->save($productMultiselect);

$categoryLinkManagement->assignProductToCategories(
    $productMultiselect->getSku(),
    [2]
);
