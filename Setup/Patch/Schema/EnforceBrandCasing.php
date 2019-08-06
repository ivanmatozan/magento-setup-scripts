<?php

declare(strict_types=1);

namespace Matozan\Magento\Setup\Patch\Schema;

use Magento\Framework\DB\Adapter\Pdo\Mysql;
use Magento\Framework\DB\Ddl\Trigger;
use Magento\Framework\DB\Ddl\TriggerFactory;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Matozan\Magento\Setup\StoredRoutinesProvider;

class EnforceBrandCasing implements SchemaPatchInterface
{
    /**
     * @var StoredRoutinesProvider
     */
    private $storedRoutinesProvider;

    /**
     * @var SchemaSetupInterface
     */
    private $schemaSetup;

    /**
     * @var TriggerFactory
     */
    private $triggerFactory;

    public function __construct(
        StoredRoutinesProvider $storedRoutinesProvider,
        SchemaSetupInterface $schemaSetup,
        TriggerFactory $triggerFactory
    ) {
        $this->storedRoutinesProvider = $storedRoutinesProvider;
        $this->schemaSetup = $schemaSetup;
        $this->triggerFactory = $triggerFactory;
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        $db = $this->schemaSetup->getConnection();

//        if ($db instanceof Mysql) {
//            foreach ($this->storedRoutinesProvider->getStoredFunctionsSql() as $sql) {
//                strpos(rtrim($sql, "; \n\t"), ';') !== false ?
//                    $db->multiQuery($sql) :
//                    $db->query($sql);
//            }
//
//            $this->createTriggerToEnforceConsistentCasing();
//        }

        return $this;
    }

    private function createTriggerToEnforceConsistentCasing(): void
    {
        $db = $this->schemaSetup->getConnection();
        $tableName = $this->schemaSetup->getTable('matozan_brand_example');

        foreach ([Trigger::EVENT_INSERT, Trigger::EVENT_UPDATE] as $event) {
            $trigger = $this->triggerFactory->create();
            $triggerName = $db->getTriggerName($tableName, Trigger::TIME_BEFORE, $event);

            $trigger
                ->setName($triggerName)
                ->setTime(Trigger::TIME_BEFORE)
                ->setEvent($event)
                ->setTable($tableName)
                ->addStatement('SET
                    NEW.name = UCWORDS(NEW.name),
                    NEW.description = CONCAT(UCFIRST_WORD(NEW.description), " ", BUT_FIRST_WORD(NEW.description))
                ');

            $db->dropTrigger($triggerName);
            $db->createTrigger($trigger);
        }
    }
}
