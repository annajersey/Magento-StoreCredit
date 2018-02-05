<?php

namespace Exto\StoreCredit\Model\ResourceModel\Points;

/**
 * Points collection
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Zend_Db_Adapter_Abstract $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource

     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Exto\StoreCredit\Model\Points', 'Exto\StoreCredit\Model\ResourceModel\Points');
    }

    /**
     * Add customer id filter
     *
     * @param int $customerId
     * @return $this
     */
    public function addCustomerIdFilter($customerId)
    {
        $this->addFieldToFilter('customer_id', $customerId);
        return $this;
    }

    /**
     * Set sort order
     *
     * @param string $column
     * @param string $dir
     * @return $this
     */
    public function setSortOrder($column, $dir = self::SORT_ORDER_DESC)
    {
        $this->setOrder($column, $dir);
        return $this;
    }
}
