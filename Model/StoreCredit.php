<?php

namespace Exto\StoreCredit\Model;

use Magento\Framework\DataObject;

class StoreCredit extends DataObject
{
    CONST POINTS_RATIO = 'exto_store_credit/general/points_ratio';

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Exto\StoreCredit\Model\BalanceFactory $balanceFactory
     */
    protected $balanceFactory;

    /*
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Customer\Model\Session $customerSession,
        \Exto\StoreCredit\Model\BalanceFactory $balanceFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->customerSession = $customerSession;
        $this->balanceFactory = $balanceFactory;
        $this->scopeConfig = $scopeConfig;
        $this->logger = $logger;
    }

    /**
     * @description return current customer points balance
     * @return bool|float
     */
    public function getCustomerPoints() {
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
     * @description convert points to money by points ratio
     * @return float
     */
    public function convertPointsToMoney($pointsAmount) {
        $pointsRatio = $this->scopeConfig->getValue(self::POINTS_RATIO);
        return floor($pointsAmount*$pointsRatio);
    }

    /**
     * @description apply points to current order
     * @return bool
     */
    public function applyPoints($pointsAmount) {
        $quote = $this->checkoutSession->getQuote();
        $quote->setStoreCredit($this->convertPointsToMoney($pointsAmount));
        $this->checkoutSession->setQuote($quote);
    }

    /**
     * @description
     * @return
     */
    public function isPointsApplied() {
        $quote = $this->checkoutSession->getQuote();
        return $quote->getStoreCredit();
    }
}