<?php

namespace Exto\StoreCredit\Model;

use Exto\StoreCredit\Api\Data\BalanceInterfaceFactory;

class Balance extends \Magento\Framework\Model\AbstractModel
{

    /**
     * @var BalanceInterfaceFactory
     */
    protected $balanceDataFactory;

    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('Exto\StoreCredit\Model\ResourceModel\Balance');
    }
    
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Exto\StoreCredit\Model\ResourceModel\Balance $resource,
        BalanceInterfaceFactory $balanceDataFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {

        $this->balanceDataFactory = $balanceDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;

        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
    }
    /**
     * Retrieve balance model with data
     *
     * @return \Exto\StoreCredit\Api\Data\BalanceInterface
     */
    public function getDataModel()
    {
        $balanceData = $this->getData();
        $balanceDataObject = $this->balanceDataFactory->create();

        $this->dataObjectHelper->populateWithArray(
            $balanceDataObject,
            $balanceData,
            '\Exto\StoreCredit\Api\Data\BalanceInterface'
        );

        return $balanceDataObject;
    }
}

