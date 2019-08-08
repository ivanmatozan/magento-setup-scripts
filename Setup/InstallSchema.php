<?php

declare(strict_types=1);

namespace Matozan\Magento\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface as Db;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @inheritDoc
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $tableName = 'mage2tv_example_brand';
        $table = $setup->getConnection()->newTable($setup->getTable($tableName));

        $table->addColumn('id', Table::TYPE_INTEGER, null, [
            'primary' => true,
            'identity' => true,
            'unsigned' => true,
            'nullable' => false
        ]);
        $table->addColumn('name', Table::TYPE_TEXT, 124, [
            'nullable' => false
        ]);
        $table->addColumn('description', Table::TYPE_TEXT, null, [
            'nullable' => false,
            'default' => ''
        ]);
        $table->addColumn('is_enabled', Table::TYPE_BOOLEAN, null, [
            'nullable' => false,
            'default' => 0
        ]);
        $table->addColumn('weighting_factor', Table::TYPE_DECIMAL, [5, 4], [
            'default' => 1
        ]);
        $table->addColumn('created_at', Table::TYPE_TIMESTAMP, null, [
            'default' => Table::TIMESTAMP_INIT
        ]);
        $table->addColumn('updated_at', Table::TYPE_TIMESTAMP, null, [
            'default' => Table::TIMESTAMP_INIT_UPDATE
        ]);
        $table->addIndex(
            $setup->getIdxName($tableName, ['is_enabled']),
            ['is_enabled']
        );
        $table->addIndex(
            $setup->getIdxName($tableName, ['name'], Db::INDEX_TYPE_UNIQUE),
            ['name'],
            ['type' => Db::INDEX_TYPE_UNIQUE]
        );
        $table->addIndex(
            $setup->getIdxName($tableName, ['description'], Db::INDEX_TYPE_FULLTEXT),
            ['name'],
            ['type' => Db::INDEX_TYPE_FULLTEXT]
        );

        $table->addColumn('store_id', Table::TYPE_SMALLINT, 5, [
            'unsigned' => true
        ]);
        $table->addForeignKey(
            $setup->getFkName($tableName, 'store_id', 'store', 'store_id'),
            'store_id',
            'store',
            'store_id',
            Db::FK_ACTION_CASCADE
        );

        $setup->getConnection()->createTable($table);

        $setup->endSetup();
    }
}
