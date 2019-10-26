<?php

declare(strict_types=1);

namespace Matozan\SetupScripts\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CreateDefaultBrands implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
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
        $brands = [
            ['name' => 'Sike', 'description' => 'Something cool'],
            ['name' => 'Luma', 'description' => 'Something not quite as cool'],
            ['name' => 'Babidas', 'description' => 'To cool to care']
        ];

        $records = array_map(static function ($brand) {
            return array_merge($brand, ['is_enabled' => 1, 'website_id' => 1]);
        }, $brands);

        $this->moduleDataSetup->getConnection()->insertMultiple(
            'matozan_brand_example',
            $records
        );

        return $this;
    }
}
