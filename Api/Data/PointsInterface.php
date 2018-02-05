<?php

namespace Exto\StoreCredit\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Points interface.
 */

interface PointsInterface extends ExtensibleDataInterface
{
    /**#@+
     * Constants defined for keys of the data array. Identical to the name of the getter in snake case
     */
    const TRANSACTION_ID = 'transaction_id';
    const STORE_ID = 'store_id';
    const CUSTOMER_ID = 'customer_id';
    const ADMIN_ID = 'admin_id';
    const ORDER_ID = 'order_id';
    const AMOUNT = 'amount';
    const ACTIONDATE = 'actiondate';
    const COMMENT = 'comment';
    /**#@-*/

    /**
     * Get Point ID
     *
     * @api
     * @return int|null
     */
    public function getId();

    /**
     * Set Point id
     *
     * @api
     * @param int $transactionId
     * @return $this
     */
    public function setId($transactionId);

    /**
     * Get store_id
     *
     * @api
     * @return int|null
     */
    public function getStoreId();

    /**
     * Set store_id
     *
     * @api
     * @param int $storeId
     * @return $this
     */
    public function setStoreId($storeId);

    /**
     * Get customer_id
     *
     * @api
     * @return int|null
     */
    public function getCustomerId();

    /**
     * Set customer_id
     *
     * @api
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * Get admin_id
     *
     * @api
     * @return int|null
     */
    public function getAdminId();

    /**
     * Set admin_id
     *
     * @api
     * @param int $adminId
     * @return $this
     */
    public function setAdminId($adminId);

    /**
     * Get order_id
     *
     * @api
     * @return int|null
     */
    public function getOrderId();

    /**
     * Set order_id
     *
     * @api
     * @param int $orderId
     * @return $this
     */
    public function setOrderId($orderId);

    /**
     * Get point $amount
     *
     * @api
     * @return float|null
     */
    public function getAmount();

    /**
     * Set amount
     *
     * @api
     * @param decimal $amount
     * @return $this
     */
    public function setAmount($amount);

    /**
     * Get point actiondate
     *
     * @api
     * @return string|null
     */
    public function getActiondate();

    /**
     * Set actiondate
     *
     * @api
     * @param float $actiondate
     * @return $this
     */
    public function setActiondate($actiondate);
    /**
     * Get point comment
     *
     * @api
     * @return text|null
     */
    public function getComment();

    /**
     * Set comment
     *
     * @api
     * @param string $comment
     * @return $this
     */
    public function setComment($comment);
}