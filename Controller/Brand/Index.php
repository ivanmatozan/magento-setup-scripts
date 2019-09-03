<?php

declare(strict_types=1);

namespace Matozan\Magento\Controller\Brand;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\Result\Raw;
use Magento\Framework\Controller\ResultFactory;
use Matozan\Magento\Model\Brand;
use Matozan\Magento\Model\BrandFactory;
use Matozan\Magento\Model\ResourceModel\Brand as ResourceModel;
use Matozan\Magento\Model\ResourceModel\Brand\Collection;
use Matozan\Magento\Model\ResourceModel\Brand\CollectionFactory;

class Index extends Action
{
    /**
     * @var BrandFactory
     */
    protected $brandFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ResourceModel
     */
    protected $resourceModel;

    /**
     * Index constructor.
     * @param BrandFactory $brandFactory
     * @param CollectionFactory $collectionFactory
     * @param ResourceModel $resourceModel
     * @param Context $context
     */
    public function __construct(
        BrandFactory $brandFactory,
        CollectionFactory $collectionFactory,
        ResourceModel $resourceModel,
        Context $context
    ) {
        $this->brandFactory = $brandFactory;
        $this->collectionFactory = $collectionFactory;
        $this->resourceModel = $resourceModel;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        /** @var Raw $result */
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);

        return $result->setContents(__CLASS__);
    }

    /**
     * @return Brand
     */
    private function createBrand(): Brand
    {
        return $this->brandFactory->create();
    }

    /**
     * @return Collection
     */
    private function createCollection(): Collection
    {
        return $this->collectionFactory->create();
    }
}
