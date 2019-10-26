<?php

declare(strict_types=1);

namespace Matozan\SetupScripts\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Brand extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('matozan_brand_example', 'id');
    }
}
