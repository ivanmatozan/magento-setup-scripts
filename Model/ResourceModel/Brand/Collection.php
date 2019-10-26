<?php

declare(strict_types=1);

namespace Matozan\SetupScripts\Model\ResourceModel\Brand;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Matozan\SetupScripts\Model\Brand::class,
            \Matozan\SetupScripts\Model\ResourceModel\Brand::class
        );
    }
}
