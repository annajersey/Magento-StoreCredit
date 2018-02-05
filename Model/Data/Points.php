<?php

namespace Exto\StoreCredit\Model\Data;

class Points extends \Magento\Framework\Api\AbstractSimpleObject implements
    \Exto\StoreCredit\Api\Data\PointsInterface
{
    /**
     * Get Point ID
     *
     * @api
     * @return int|null
     */
    public function getId()
    {
        return $this->_get(self::TRANSACTION_ID);
    }

    /**
     * Set Point id
     *
     * @api
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::TRANSACTION_ID, $id);
    }

    /**
     * Get store_id
     *
     * @api
     * @return int|null
     */
    public function getStoreId()
    {
        return $this->_get(self::STORE_ID);
    }

    /**
     * Set store_id
     *
     * @api
     * @param int $store_id
     * @return $this
     */
    public function setStoreId($storeId)
    {
        return $this->setData(self::STORE_ID, $storeId);
    }

    /**
     * Get customer_id
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
     * @param int $customer_id
     * @return $this
     */
    public function setCustomerId($customerId)
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    /**
     * Get admin_id
     *
     * @api
     * @return int|null
     */
    public function getAdminId()
    {
        return $this->_get(self::ADMIN_ID);
    }

    /**
     * Set admin_id
     *
     * @api
     * @param int $admin_id
     * @return $this
     */
    public function setAdminId($adminId)
    {
        return $this->setData(self::ADMIN_ID, $adminId);
    }

    /**
     * Get order_id
     *
     * @api
     * @return int|null
     */
    public function getOrderId()
    {
        return $this->_get(self::ORDER_ID);
    }

    /**
     * Set order_id
     *
     * @api
     * @param int $order_id
     * @return $this
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }

    /**
     * Get point $amount
     *
     * @api
     * @return float|null
     */
    public function getAmount()
    {
        return $this->_get(self::AMOUNT);
    }

    /**
     * Set amount
     *
     * @api
     * @param float $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        return $this->setData(self::AMOUNT, $amount);
    }

    /**
     * Get point actiondate
     *
     * @api
     * @return string|null
     */
    public function getActiondate()
    {
        return $this->_get(self::ACTIONDATE);
    }

    /**
     * Set actiondate
     *
     * @api
     * @param float $actiondate
     * @return $this
     */
    public function setActiondate($actiondate)
    {
        return $this->setData(self::ACTIONDATE, $actiondate);
    }

    /**
     * Get point comment
     *
     * @return string|null
     */
    public function getComment()
    {
        return $this->_get(self::COMMENT);
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return $this
     */
    public function setComment($comment)
    {
        return $this->setData(self::COMMENT, $comment);
    }

}