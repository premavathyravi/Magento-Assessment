<?php

namespace Tracking\AddToCart\Model;

class Cartdata extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init(\Tracking\AddToCart\Model\ResourceModel\Cartdata::class);
    }
}
