<?php

namespace Exto\StoreCredit\Model\Plugin\Checkout\Type;

use \Exto\StoreCredit\Model\Points;

class Onepage
{
    /**
     * @var \Exto\StoreCredit\Model\BalanceFactory
     */
    protected $balanceFactory;

    /**
     * @var Exto\StoreCredit\Model\PointsFactory
     */
    protected $pointsFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $dateTime;

    public function __construct(
        \Exto\StoreCredit\Model\BalanceFactory $balanceFactory,
        \Exto\StoreCredit\Model\PointsFactory $pointsFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime
    ) {
        $this->balanceFactory = $balanceFactory;
        $this->pointsFactory = $pointsFactory;
        $this->logger = $logger;
        $this->dateTime = $dateTime;
    }

    public function afterPlace(\Magento\Sales\Model\Service\OrderService\Interceptor $subject, $result)
    {
        $orderId = $result->getId();
        $storeId = $result->getStoreId();
        $customerId = $result->getCustomerId();
        $amount = $result->getBaseSubtotal();
        $amount = floor($amount);
        try {
            $point = $this->pointsFactory->create();
            $point->setStoreId($storeId)
                ->setCustomerId($customerId)
                ->setAdminId(0)
                ->setOrderId($orderId)
                ->setAmount($amount)
                ->save();
            $balance = $this->balanceFactory->create();
            $customerBalance = $balance->load($customerId);
            $customerBalanceAmount = $customerBalance->getBalance() + $amount;
            $balance->setStoreId($storeId)
                ->setCustomerId($customerId)
                ->setBalance($customerBalanceAmount)
                ->setUpdateTime($this->dateTime->gmtDate())
                ->save();
        } catch (\Exception $e) {
            $this->logger->addDebug($e->getMessage());
        }
        return $result;
    }
}