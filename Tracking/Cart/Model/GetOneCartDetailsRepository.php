<?php

namespace Tracking\Cart\Model;

use Tracking\Cart\Api\GetOneCartDetailsInterface;
use Tracking\Cart\Api\Data\CartInterfaceFactory;
use Tracking\Cart\Model\CartdataFactory as CartModel;
use Tracking\Cart\Model\ResourceModel\Cartdata as CartResource;
use Tracking\Cart\Model\ResourceModel\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class GetOneCartDetailsRepository implements GetOneCartDetailsInterface
{
    /**
     * @var CartInterfaceFactory
     */

    private $cartInterfaceFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CartModel
     */
    private $model;

    /**
     * @var CartResource
     */

    private $resource;

    public function __construct(
        CollectionFactory $collectionFactory,
        CartInterfaceFactory $cartInterfaceFactory,
        CartModel $model,
        CartResource $resource
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->cartInterfaceFactory = $cartInterfaceFactory;
        $this->model = $model;
        $this->resource = $resource;
    }
    /**
     * @param int $id
     * @return \Tracking\Cart\Api\Data\CartInterface[]
     */
    public function getCartById(int $id)
    {
        $model = $this->model->create();
        $this->resource->load($model, $id, 'id');
        $model->getData();

        $cartInterface = $this->cartInterfaceFactory->create();
        $cartInterface->setId($model->getId());
        $cartInterface->setSku($model->getSku());
        $cartInterface->setCustomerId($model->getCustomerId());
        $cartInterface->setQuoteId($model->getQuoteId());
        $cartInterface->setCreatedAt($model->getCreatedAt());
        $data[] = $cartInterface;
        return $data;
    }
}
