<?php

declare(strict_types=1);

namespace Matozan\Magento\Model\ResourceModel\Brand;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Matozan\Magento\Model\Brand::class,
            \Matozan\Magento\Model\ResourceModel\Brand::class
        );
    }
}
