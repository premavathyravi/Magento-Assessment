<?php

namespace Tracking\AddToCart\Observer\Product;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Tracking\AddToCart\Model\CartdataFactory as CartModel;
use Tracking\AddToCart\Model\ResourceModel\Cartdata as CartResource;
use Magento\Customer\Model\SessionFactory as CustomerSession;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\Http\Context;
use Tracking\AddToCart\Publisher\TrackingCart;

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
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var CustomerSession
     */
    protected $session;

    /** @var */
    protected $customerData;

    /**
     * @param CartModel $model
     * @param CartResource $resource
     * @param Context $httpContext
     * @param TrackingCart $publisher
     * @param CheckoutSession $checkoutSession
     * @param CustomerSession $session
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function __construct(
        CartModel $model,
        CartResource  $resource,
        Context $httpContext,
        Trackingcart  $publisher,
        CheckoutSession $checkoutSession,
        CustomerSession $session
    ) {
        $this->model = $model;
        $this->resource = $resource;
        $this->httpContext = $httpContext;
        $this->publisher = $publisher;
        $this->checkoutSession = $checkoutSession;
        $this->session= $session->create();
        $this->customerData = ($this->session->isLoggedIn()) ? $this->session->getCustomerData() : null;
    }

    /**
     * Below is the method that will fire whenever the event runs!
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Quote\Model\Quote  */
        $quote = $this->checkoutSession->getQuote();
        $quoteId = $quote->getId();

        $product = $observer->getProduct();
        $sku = $product->getSku();

        if ($this->customerData) {
            $customerId = $this->customerData->getId();
        } else {
            $customerId = null;
        }

        $cartarr = [
            "sku" => $sku,
            "customer_id" => $customerId,
            "quote_id" => $quoteId
        ];
        $this->publisher->publish($cartarr);
    }
}
