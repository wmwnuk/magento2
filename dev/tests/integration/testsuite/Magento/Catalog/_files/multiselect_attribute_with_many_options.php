<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
/* Create attribute */
/** @var $installer \Magento\Catalog\Setup\CategorySetup */

use Magento\Eav\Api\Data\AttributeOptionInterface;

$installer = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
    \Magento\Catalog\Setup\CategorySetup::class
);
/** @var $attribute \Magento\Catalog\Model\ResourceModel\Eav\Attribute */
$attribute = \Magento\TestFramework\Helper\Bootstrap::getObjectManager()->create(
    \Magento\Catalog\Model\ResourceModel\Eav\Attribute::class
);
$entityType = $installer->getEntityTypeId('catalog_product');
if (!$attribute->loadByCode($entityType, 'multiselect_attribute_with_many_options')->getAttributeId()) {
    $values = [];
    $orders = [
        'option_1' => 1,
        'option_2' => 2,
        'option_3' => 3,
        'option_4' => 4,
    ];
    foreach (range(1, 200) as $optionNum) {
        $values[sprintf('option_%s', $optionNum)] = [sprintf('Option %s', $optionNum)];
        $orders[sprintf('option_%s', $optionNum)] = $optionNum;
    }
    $attribute->setData(
        [
            'attribute_code' => 'multiselect_attribute_with_many_options',
            'entity_type_id' => $entityType,
            'is_global' => 1,
            'is_user_defined' => 1,
            'frontend_input' => 'multiselect',
            'is_unique' => 0,
            'is_required' => 0,
            'is_searchable' => 0,
            'is_visible_in_advanced_search' => 0,
            'is_comparable' => 0,
            'is_filterable' => 1,
            'is_filterable_in_search' => 0,
            'is_used_for_promo_rules' => 0,
            'is_html_allowed_on_front' => 1,
            'is_visible_on_front' => 0,
            'used_in_product_listing' => 0,
            'used_for_sort_by' => 0,
            'frontend_label' => ['Multiselect Attribute withMany Options'],
            'backend_type' => 'text',
            'backend_model' => \Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend::class,
            'option' => [
                'value' => $values,
                'order' => $orders,
        ],
        ]
    );

    $attribute->save();

    /* Assign attribute to attribute set */
    $installer->addAttributeToGroup('catalog_product', 'Default', 'General', $attribute->getId());
}
