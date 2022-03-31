<?php

namespace Tracking\Cart\Api;

interface DeleteCartDetailsInterface
{

    /**
     * @param int $id
     * @return \Tracking\Cart\Api\Data\CartInterface[]
     */
    public function deleteCartById(int $id);
}
