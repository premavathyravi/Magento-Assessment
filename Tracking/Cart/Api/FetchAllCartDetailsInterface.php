<?php

namespace Tracking\Cart\Api;

interface FetchAllCartDetailsInterface
{

    /**
     * @param int|null $pageId
     * @return \Tracking\Cart\Api\Data\CartInterface[]
     */
    public function getCartList(int $pageId = null);
}
