<?php

declare(strict_types=1);

namespace Matozan\Magento\Setup;

use Magento\Framework\DB\Ddl\Table;
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
        $setup->startSetup();

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

        // Add new column
        if (version_compare($context->getVersion(), '1.1.0', '<')) {
            $setup->getConnection()->addColumn($setup->getTable($tableName), 'image_url', [
                'type' => Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'after' => 'description',
                'comment' => 'Image URL'
            ]);
        }

        // Modify existing column
        if (version_compare($context->getVersion(), '1.2.0', '<')) {
            $setup->getConnection()->changeColumn(
                $setup->getTable($tableName),
                'image_url',
                'image_url',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 512,
                    'nullable' => true,
                    'after' => 'description',
                    'comment' => 'Image URL'
                ]
            );
        }

        // Rename table name
        if (version_compare($context->getVersion(), '1.3.0', '<')) {
            $setup->getConnection()->renameTable(
                $setup->getTable('mage2tv_example_brand'),
                $setup->getTable('mage2tv_example_new_brand')
            );
        }

        $setup->endSetup();
    }
}
