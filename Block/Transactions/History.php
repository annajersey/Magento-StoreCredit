<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Exto\StoreCredit\Block\Transactions;

/**
 * Sales order history block
 */
class History extends \Magento\Framework\View\Element\Template
{
    /**
     * @var string
     */
    protected $_template = 'store_credit_history.phtml';

    /**
     * @var \Exto\StoreCredit\Model\ResourceModel\Points\CollectionFactory
    protected $pointsCollectionFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Exto\StoreCredit\Model\BalanceFactory $balanceFactory
     */
    protected $balanceFactory;

    /**
     * @var \Exto\StoreCredit\Model\ResourceModel\Points\Collection
     */
    protected $transactions;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Exto\StoreCredit\Model\ResourceModel\Points\CollectionFactory $pointsCollectionFactory
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Exto\StoreCredit\Model\BalanceFactory $balanceFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Exto\StoreCredit\Model\ResourceModel\Points\CollectionFactory $pointsCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Exto\StoreCredit\Model\BalanceFactory $balanceFactory,
        \Psr\Log\LoggerInterface $logger,
        array $data = []
    ) {
        $this->pointsCollectionFactory = $pointsCollectionFactory;
        $this->customerSession = $customerSession;
        $this->balanceFactory = $balanceFactory;
        $this->logger = $logger;
        parent::__construct($context, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->pageConfig->getTitle()->set(__('My Store credit'));
    }

    /**
     * @return bool|\Exto\StoreCredit\Model\ResourceModel\Points\Collection
     */
    public function getTransactions()
    {
        if (!($customerId = $this->customerSession->getCustomerId())) {
            return false;
        }
        if (!$this->transactions) {
            $this->transactions = $this->pointsCollectionFactory->create()->addFieldToSelect(
                '*'
            )->addFieldToFilter(
                'customer_id',
                $customerId
            )->setOrder(
                'actiondate',
                'desc'
            );
        }
        return $this->transactions;
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getTransactions()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'exto.storecredit.transactions.history.pager'
            )->setCollection(
                $this->getTransactions()
            );
            $this->setChild('pager', $pager);
            $this->getTransactions()->load();
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    /**
     * @description current customer points balance
     * @return bool|float
     */
    public function getPointsBalance() {
        if (!($customerId = $this->customerSession->getCustomerId())) {
            return false;
        }
        try {
            $customerBalance = $this->balanceFactory->create()->load($customerId);
            return $customerBalance->getBalance();
        } catch (\Exception $e) {
            $this->logger->addDebug($e->getMessage());
            return false;
        }
    }

    /**
     * @description Return real Magento order number
     * @param int $orderId
     * @return string
     */
    public function getOrderRealId($orderId) {
        if (!$orderId) {
            return __('N/A');
        }
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->create('Magento\Sales\Model\Order')->load($orderId);
        if ($order) {
            return $order->getRealOrderId();
        }
        return false;
    }

    /**
     * @description
     * @return
     */
    public function formatPrice($price) {
        return sprintf('%.2fpt', $price);
    }
}
