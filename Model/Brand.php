<?php

declare(strict_types=1);

namespace Matozan\SetupScripts\Model;

use Magento\Framework\Model\AbstractModel;

class Brand extends AbstractModel
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\Brand::class);
    }
}
