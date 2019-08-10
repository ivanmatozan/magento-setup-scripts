<?php

declare(strict_types=1);

namespace Matozan\Magento\Setup;

use Magento\Catalog\Api\Data\CategoryAttributeInterface;
use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Model\ResourceModel\Attribute as AttributeResource;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetup
     */
    private $eavSetup;

    /**
     * @var EavConfig
     */
    private $eavConfig;

    /**
     * @var AttributeResource
     */
    private $attributeResource;

    public function __construct(
        EavSetup $eavSetup,
        EavConfig $eavConfig,
        AttributeResource $attributeResource
    ) {
        $this->eavSetup = $eavSetup;
        $this->eavConfig = $eavConfig;
        $this->attributeResource = $attributeResource;
    }

    /**
     * @inheritDoc
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->createProductAttribute();
        $this->createCategoryAttribute();
        $this->createCustomerAttribute();
    }

    private function createProductAttribute(): void
    {
        $attributeCode = 'legacy_sku';
        $entityType = ProductAttributeInterface::ENTITY_TYPE_CODE;

        $setId = $this->eavSetup->getDefaultAttributeSetId($entityType);
        $groupId = $this->eavSetup->getDefaultAttributeGroupId($entityType, $setId);
        $groupName = $this->eavSetup->getAttributeGroup(
            $entityType,
            $setId,
            $groupId,
            'attribute_group_name'
        );

        $this->eavSetup->addAttribute($entityType, $attributeCode, [
            'label' => 'Legacy SKU',
            'required' => 0,
            'user_defined' => 1,
            'unique' => 1,
            'searchable' => 1,
            'visible_on_front' => 1,
            'visible_in_advanced_search' => 1,
            'is_used_in_grid' => 1,
            'group' => $groupName,
            'sort_order' => 30
        ]);
    }

    private function createCategoryAttribute(): void
    {
        $attributeCode = 'external_id';
        $entityType = CategoryAttributeInterface::ENTITY_TYPE_CODE;

        $this->eavSetup->addAttribute($entityType, $attributeCode, [
            'label' => 'External Id',
            'user_defined' => 1,
            'unique' => 1
        ]);

        $setId = $this->eavSetup->getDefaultAttributeSetId($entityType);
        $groupId = $this->eavSetup->getDefaultAttributeGroupId($entityType, $setId);

        $this->eavSetup->addAttributeToSet($entityType, $setId, $groupId, $attributeCode);
    }

    private function createCustomerAttribute(): void
    {
        $attributeCode = 'interests';
        $entityType = CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER;
        $setId = CustomerMetadataInterface::ATTRIBUTE_SET_ID_CUSTOMER;

        $this->eavSetup->addAttribute($entityType, $attributeCode, [
            'label' => 'Interests',
            'required' => 0,
            'user_defined' => 1,
            'note' => 'Separate multiple interests with a comma.',
            'system' => 0,
            'position' => 100
        ]);

        $this->eavSetup->addAttributeToSet($entityType, $setId, null, $attributeCode);

        $attribute = $this->eavConfig->getAttribute($entityType, $attributeCode);
        $attribute->setData('used_in_forms', [
            'adminhtml_customer',
            // In opensource version we need to manually add fields to create/edit forms
            'customer_account_create',
            'customer_account_edit'
        ]);
        $this->attributeResource->save($attribute);
    }
}
