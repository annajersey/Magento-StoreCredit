<?php

namespace Exto\StoreCredit\Model\ResourceModel;

class Balance extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('exto_points_balance', 'balance_id');
    }
    
    /**
     * Load balance by customerId
     *
     * @param \Exto\StoreCredit\Model\Balance $balance
     * @param int $customerId
     * @return $balance
     */
    public function loadByCustomerId(\Exto\StoreCredit\Model\Balance $balance, $customerId)
    {
        $connection = $this->getConnection();
        $bind = ['customerId' => $customerId];
        $select = $connection->select()->from(
            'exto_points_balance',
            ['balance_id']
        )->where(
            'customer_id = :customerId'
        );

        $balanceId = $connection->fetchOne($select, $bind);
        if ($balanceId) {
            $this->load($balance, $balanceId);
        } else {
            $balance->setData([]);
        }
         
        return $balance;
    }
}

