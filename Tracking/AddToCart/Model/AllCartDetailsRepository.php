<?php

namespace Tracking\AddToCart\Model;

use Tracking\AddToCart\Api\AllCartDetailsInterface;
use Tracking\AddToCart\Api\Data\CartInterfaceFactory;
use Tracking\AddToCart\Model\ResourceModel\CollectionFactory;
use Tracking\AddToCart\Model\CartdataFactory as CartModel;
use Tracking\AddToCart\Model\ResourceModel\Cartdata as CartResource;

class AllCartDetailsRepository implements AllCartDetailsInterface
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

    /**
     * @param CollectionFactory $collectionFactory
     * @param CartInterfaceFactory $cartInterfaceFactory
     * @param CartdataFactory $model
     * @param CartResource $resource
     */
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
     * @param int|null $pageId
     * @return \Tracking\AddToCart\Api\Data\CartInterface[]
     */
    public function getCartList(int $pageId = null)
    {
        if ($pageId == null) {
            $pageId = 1;
        }
        $data = [];
        try {
            $cartCollection = $this->collectionFactory->create()->setPageSize(5)->setCurPage($pageId);

            foreach ($cartCollection as $item) {
                $cartInterface = $this->cartInterfaceFactory->create();
                $cartInterface->setId($item->getId());
                $cartInterface->setSku($item->getSku());
                $cartInterface->setCustomerId($item->getCustomerId());
                $cartInterface->setQuoteId($item->getQuoteId());
                $cartInterface->setCreatedAt($item->getCreatedAt());
                $data[] = $cartInterface;
            }
            return $data;
        } catch (LocalizedException $e) {
            throw LocalizedException(__('No data found'));
        }
    }

    /**
     * @param int $id
     * @return \Tracking\AddToCart\Api\Data\CartInterface[]
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

    /**
     * @param int $id
     * @return \Tracking\AddToCart\Api\Data\CartInterface[]
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

    /**
     * @param string $sku
     * @param int $quoteId
     * @param int $customerId
     * @param $createdAt
     * @return \Tracking\AddToCart\Api\Data\CartInterface[]
     */
    public function saveCart(string $sku, int $quoteId, int $customerId = null, $createdAt = null)
    {
        $model = $this->model->create();
        $model->setSku($sku);
        $model->setQuoteId($quoteId);

        if ($customerId != null) {
            $model->setCustomerId($customerId);
        }

        if ($createdAt != null) {
            $model->setCreatedAt($createdAt);
        }
        try {
            $this->resource->save($model);
            $response = ['success' => 'Saved Successfully'];
            return $response;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param int $id
     * @param string $sku
     * @param int $quoteId
     * @param int $customerId
     * @param $createdAt
     * @return \Tracking\AddToCart\Api\Data\CartInterface[]
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
