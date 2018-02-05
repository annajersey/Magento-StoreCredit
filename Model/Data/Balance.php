<?php

namespace Exto\StoreCredit\Model\Data;

class Balance extends \Magento\Framework\Api\AbstractSimpleObject implements
    \Exto\StoreCredit\Api\Data\BalanceInterface
{
    /**
     * Get Balance ID
     *
     * @api
     * @return int|null
     */
    public function getBalanceId()
    {
        return $this->_get(self::BALANCE_ID);
    }

    /**
     * Set Balance id
     *
     * @api
     * @param int $balanceId
     * @return $this
     */
    public function setBalanceId($balanceId)
    {
        return $this->setData(self::BALANCE_ID, $balanceId);
    }

    /**
     * Get storeId
     *
     * @api
     * @return int|null
     */
    public function getStoreId()
    {
        return $this->_get(self::STORE_ID);
    }

    /**
     * Set storeId
     *
     * @api
     * @param int $storeId
     * @return $this
     */
    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }

    /**
     * Get customerId
     *
     * @api
     * @return int|null
     */
    public function getCustomerId()
    {
        return $this->_get(self::CUSTOMER_ID);
    }

    /**
     * Set customer_id
     *
     * @api
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }


    /**
     * Get customer balance
     *
     * @api
     * @return float|null
     */
    public function getBalance()
    {
        return $this->_get(self::BALANCE);
    }

    /**
     * Set customer balance
     *
     * @api
     * @param float $balance
     * @return $this
     */
    public function setBalance($balance)
    {
        return $this->setData(self::BALANCE, $balance);
    }

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return $this
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return $this
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return $this
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime()
    {
        return $this->_get(self::CREATION_TIME);
    }

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime()
    {
        return $this->_get(self::UPDATE_TIME);
    }

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive()
    {
        return (bool) $this->_get(self::IS_ACTIVE);
    }

}