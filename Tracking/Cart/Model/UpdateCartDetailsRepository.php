<?php

namespace Tracking\Cart\Model;

use Tracking\Cart\Api\UpdateCartDetailsInterface;
use Tracking\Cart\Api\Data\CartInterfaceFactory;
use Tracking\Cart\Model\CartdataFactory as CartModel;
use Tracking\Cart\Model\ResourceModel\Cartdata as CartResource;
use Tracking\Cart\Model\ResourceModel\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class UpdateCartDetailsRepository implements UpdateCartDetailsInterface
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
     * @param string $sku
     * @param int $quoteId
     * @param int $customerId
     * @param $createdAt
     * @return \Tracking\Cart\Api\Data\CartInterface[]
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function updateCart($id, string $sku = null, int $quoteId = null, int $customerId = null, $createdAt = null)
    {
        $model = $this->model->create();
        $this->resource->load($model, $id, 'id');

        if ($sku != null) {
            $model->setSku($sku);
        }

        if ($quoteId != null) {
            $model->setQuoteId($quoteId);
        }

        if ($customerId != null) {
            $model->setCustomerId($customerId);
        }

        if ($createdAt != null) {
            $model->setCreatedAt($createdAt);
        }
        try {
            $this->resource->save($model);
            $response = ['success' => 'Updated Successfully'];
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
