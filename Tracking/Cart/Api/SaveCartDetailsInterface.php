<?php

namespace Tracking\Cart\Api;

interface SaveCartDetailsInterface
{
    /**
     * @param string $sku
     * @param int $quoteId
     * @param int $customerId
     * @param $createdAt
     * @return \Tracking\Cart\Api\Data\CartInterface[]
     */
    public function saveCart(string $sku, int $quoteId, int $customerId = null, $createdAt = null);
}
