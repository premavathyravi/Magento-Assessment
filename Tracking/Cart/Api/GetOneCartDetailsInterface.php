<?php

namespace Tracking\Cart\Api;

interface GetOneCartDetailsInterface
{
    /**
     * @param int $id
     * @return \Tracking\Cart\Api\Data\CartInterface[]
     */
    public function getCartById(int $id);
}
