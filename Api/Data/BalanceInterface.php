<?php

namespace Exto\StoreCredit\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Points interface.
 */

interface BalanceInterface extends ExtensibleDataInterface
{
    /**#@+
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const BALANCE_ID = 'balance_id';
    const STORE_ID = 'store_id';
    const CUSTOMER_ID = 'customer_id';
    const BALANCE = 'balance';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const IS_ACTIVE = 'is_active';
    /**#@-*/

    /**
     * Get Balance ID
     *
     * @api
     * @return int|null
     */
    public function getBalanceId();

    /**
     * Set Balance id
     *
     * @api
     * @param int $balanceId
     * @return $this
     */
    public function setBalanceId($balanceId);

    /**
     * Get store_id
     *
     * @api
     * @return int|null
     */
    public function getStoreId();

    /**
     * Set storeId
     *
     * @api
     * @param int $storeId
     * @return $this
     */
    public function setStoreId($storeId);

    /**
     * Get customerId
     *
     * @api
     * @return int|null
     */
    public function getCustomerId();

    /**
     * Set customerId
     *
     * @api
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);


    /**
     * Get customer balance
     *
     * @api
     * @return float|null
     */
    public function getBalance();

    /**
     * Set customer balance
     *
     * @api
     * @param decimal $amount
     * @return $this
     */
    public function setBalance($amount);

    /**
     * Set creation time
     *
     * @param string $creationTime
     * @return $this
     */
    public function setCreationTime($creationTime);

    /**
     * Set update time
     *
     * @param string $updateTime
     * @return $this
     */
    public function setUpdateTime($updateTime);

    /**
     * Set is active
     *
     * @param int|bool $isActive
     * @return $this
     */
    public function setIsActive($isActive);

    /**
     * Get creation time
     *
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Get update time
     *
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Is active
     *
     * @return bool|null
     */
    public function isActive();
}
