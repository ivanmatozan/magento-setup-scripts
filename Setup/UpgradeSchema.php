<?php

declare(strict_types=1);

namespace Matozan\Magento\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @inheritDoc
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $tableName = 'mage2tv_example_brand';

        // Check if table exists
        $setup->tableExists($tableName);
        $setup->getConnection()->isTableExists($setup->getTable($tableName));

        // Check if column exists
        $setup->getConnection()->tableColumnExists(
            $setup->getTable($tableName),
            'description'
        );

        // Get detailed information about columns
        $setup->getConnection()->describeTable($setup->getTable($tableName));

        // Listing indexes and foreign keys
        $setup->getConnection()->getIndexList($setup->getTable($tableName));
        $setup->getConnection()->getForeignKeys($setup->getTable($tableName));
    }
}
