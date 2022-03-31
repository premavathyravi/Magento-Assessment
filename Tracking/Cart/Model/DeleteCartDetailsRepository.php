<?php

namespace Tracking\Cart\Model;

use Tracking\Cart\Api\DeleteCartDetailsInterface;
use Tracking\Cart\Api\Data\CartInterfaceFactory;
use Tracking\Cart\Model\CartdataFactory as CartModel;
use Tracking\Cart\Model\ResourceModel\Cartdata as CartResource;
use Tracking\Cart\Model\ResourceModel\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class DeleteCartDetailsRepository implements DeleteCartDetailsInterface
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
    public function deleteCartById(int $id)
    {
        $model = $this->model->create();
        $this->resource->load($model, $id, 'id');

        try {
            $this->resource->delete($model);
            $response = ['success' => 'Deleted Successfully'];
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
