<?php

namespace Tracking\AddToCart\Model\ResourceModel;

class Cartdata extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init("track_cart", "id");
    }
}
