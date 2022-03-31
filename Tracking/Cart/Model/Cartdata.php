<?php

namespace Tracking\Cart\Model;

class Cartdata extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        $this->_init("Tracking\Cart\Model\ResourceModel\Cartdata");
    }
}
