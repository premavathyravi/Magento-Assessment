<?php

namespace Tracking\AddToCart\Consumer;

use Magento\Framework\Serialize\SerializerInterface;
use Tracking\AddToCart\Model\CartdataFactory as CartModel;
use Tracking\AddToCart\Model\ResourceModel\Cartdata as CartResource;

class TrackingCart
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var CartModel
     */
    protected $model;

    /**
     * @var CartResource
     */
    protected $resource;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(
        SerializerInterface $serializer,
        CartModel $model,
        CartResource $resource
    ) {
        $this->serializer = $serializer;
        $this->model = $model;
        $this->resource = $resource;
    }

    /**
     * @param $data
     * @return void
     */
    public function consume($data)
    {
        $model = $this->model->create();
        $unserialarr = $this->serializer->unserialize($data);
        $model->setData($unserialarr);
        try {
            $this->resource->save($model);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
