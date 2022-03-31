<?php

namespace Tracking\Cart\Model\ResourceModel;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    public function _construct()
    {
        $this->_init("Tracking\Cart\Model\Cartdata", "Tracking\Cart\Model\ResourceModel\Cartdata");
    }
}
