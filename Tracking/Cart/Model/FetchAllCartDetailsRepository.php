<?php

namespace Tracking\Cart\Model;

use Tracking\Cart\Api\FetchAllCartDetailsInterface;
use Tracking\Cart\Api\Data\CartInterfaceFactory;
use Tracking\Cart\Model\ResourceModel\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class FetchAllCartDetailsRepository implements FetchAllCartDetailsInterface
{
    /**
     * @var CartInterfaceFactory
     */

    private $cartInterfaceFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory,
        CartInterfaceFactory $cartInterfaceFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->cartInterfaceFactory = $cartInterfaceFactory;
    }


    /**
     * @param int|null $pageId
     * @return \Tracking\Cart\Api\Data\CartInterface[]
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
}
