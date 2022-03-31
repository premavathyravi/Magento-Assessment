<?php

namespace Tracking\Cart\Observer\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Tracking\Cart\Model\CartdataFactory as CartModel;
use Tracking\Cart\Model\ResourceModel\Cartdata as CartResource;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Http\Context;
use Tracking\Cart\Publisher\TrackingCart;

class Data implements ObserverInterface
{
    /**
     * @var Context
     */
    protected $httpContext;

    /**
     * @var CartModel
     */
    protected $model;
    /**
     * @var TrackingCart
     */
    protected $publisher;

    /**
     * @var CartResource
     */
    protected $resource;

    /**
     * @param CartModel $model
     * @param CartResource $resource
     * @param Context $httpContext
     * @param TrackingCart $publisher
     */
    public function __construct(
        CartModel $model,
        CartResource  $resource,
        Context $httpContext,
        Trackingcart  $publisher
    ) {
        $this->model = $model;
        $this->resource = $resource;
        $this->httpContext = $httpContext;
        $this->publisher = $publisher;
    }

    /**
     * Below is the method that will fire whenever the event runs!
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');
        $quote = $cart->getQuote();
        $quoteId = $quote->getId();

        $product = $observer->getProduct();
        $sku = $product->getSku();
        $customerId = $this->httpContext->getValue('customer_id');

        if ($customerId ==0) {
            $customerId = null;
        }
        if ($customerId !=0) {
            $customerId = $customerId;
        }

        $cartarr = [
            "sku" => $sku,
            "customer_id" => $customerId,
            "quote_id" => $quoteId
        ];
        $this->publisher->publish($cartarr);
    }
}
