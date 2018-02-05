<?php

/**
 * Points item collection grouped by customer id
 */
namespace Exto\StoreCredit\Model\ResourceModel\Points\Collection;

use Magento\Customer\Controller\RegistryConstants as RegistryConstants;


class CustomerTransactionsGrid extends \Exto\Storecredit\Model\ResourceModel\Points\Collection
{
   

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registryManager;
    
    public function __construct(
        \Magento\Framework\Registry $registry,    
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        $this->registryManager = $registry;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }
    
    /**
     * Initialize db select
     *
     * @return $this
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $this->addCustomerIdFilter(
            $this->registryManager->registry(RegistryConstants::CURRENT_CUSTOMER_ID)
        );
        return $this;
    }

    
    
  
}
