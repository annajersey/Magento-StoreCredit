<?php

namespace Exto\StoreCredit\Model;

class Points extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Exto\StoreCredit\Model\ResourceModel\Points');
    }
}