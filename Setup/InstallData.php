<?php

declare(strict_types=1);

namespace Matozan\Magento\Setup;

use Magento\Catalog\Api\Data\CategoryAttributeInterface;
use Magento\Catalog\Api\Data\ProductAttributeInterface;
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

    public function __construct(EavSetup $eavSetup)
    {
        $this->eavSetup = $eavSetup;
    }

    /**
     * @inheritDoc
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->createProductAttribute();
        $this->createCategoryAttribute();
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
}
