<?php

namespace Exto\StoreCredit\Model\ResourceModel;

class Points extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('exto_points_transactions', 'transaction_id');
    }
}
