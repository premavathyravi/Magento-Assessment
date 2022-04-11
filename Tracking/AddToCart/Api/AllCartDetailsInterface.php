<?php

namespace Tracking\AddToCart\Api;

interface AllCartDetailsInterface
{

    /**
     * @param int|null $pageId
     * @return \Tracking\AddToCart\Api\Data\CartInterface[]
     */
    public function getCartList(int $pageId = null);

    /**
     * @param int $id
     * @return \Tracking\AddToCart\Api\Data\CartInterface[]
     */
    public function deleteCartById(int $id);

    /**
     * @param int $id
     * @return \Tracking\AddToCart\Api\Data\CartInterface[]
     */
    public function getCartById(int $id);

    /**
     * @param string $sku
     * @param int $quoteId
     * @param int $customerId
     * @param $createdAt
     * @return \Tracking\AddToCart\Api\Data\CartInterface[]
     */
    public function saveCart(string $sku, int $quoteId, int $customerId = null, $createdAt = null);

    /**
     * @param int $id
     * @param string $sku
     * @param int $quoteId
     * @param int $customerId
     * @param $createdAt
     * @return \Tracking\AddToCart\Api\Data\CartInterface[]
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function updateCart($id, string $sku = null, int $quoteId = null, int $customerId = null, $createdAt = null);
}
