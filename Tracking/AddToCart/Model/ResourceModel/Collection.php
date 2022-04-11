<?php

namespace Tracking\AddToCart\Model\ResourceModel;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public function _construct()
    {
        $this->_init(\Tracking\AddToCart\Model\Cartdata::class, \Tracking\AddToCart\Model\ResourceModel\Cartdata::class);
    }
}
