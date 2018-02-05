<?php

namespace Exto\StoreCredit\Controller\Adminhtml\Customer;

use Magento\Backend\App\Action;

class UpdateBalance extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    /**
     * @var Exto\StoreCredit\Api\Data\PointsInterfaceFactory
     */
    protected $pointsDataFactory;

    /**
     * @var Exto\StoreCredit\Api\PointsRepositoryInterface
     */
    protected $pointsRepository;

    /**
     * @var Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var Magento\Backend\Model\Auth\Session
     */
    protected $authSession;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Exto\StoreCredit\Api\Data\BalanceInterfaceFactory
     */
    protected $balanceDataFactory;

    /**
     * @var Exto\StoreCredit\Api\BalanceRepositoryInterface
     */
    protected $balanceRepository;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $dateTime;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param Action\Context $context
     */
    public function __construct(
        Action\Context $context,
        \Exto\StoreCredit\Api\Data\PointsInterfaceFactory $pointsDataFactory,
        \Exto\StoreCredit\Api\Data\BalanceInterfaceFactory $balanceDataFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Exto\StoreCredit\Api\PointsRepositoryInterface $pointsRepository,
        \Exto\StoreCredit\Api\BalanceRepositoryInterface $balanceRepository,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Stdlib\DateTime\DateTime $dateTime,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->pointsDataFactory = $pointsDataFactory;
        $this->balanceDataFactory = $balanceDataFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->pointsRepository = $pointsRepository;
        $this->balanceRepository = $balanceRepository;
        $this->authSession = $authSession;
        $this->storeManager = $storeManager;
        $this->dateTime = $dateTime;
        $this->logger = $logger;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Exto_StoreCredit::exto_store_credit_balance_change');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\Result\JsonFactory
     */
    public function execute()
    {
        $result = $this->resultJsonFactory->create();
        try{
            $postData = $this->getRequest()->getPostValue();
            $data = $postData['transaction'];
            $admin = $this->authSession->getUser();

            //creating new transaction
            $transactionData = [
                'store_id'=>$this->storeManager->getStore()->getId(),
                'customer_id'=>$data['customer_id'],
                'admin_id'=>$admin->getId(),
                'amount'=>$data['amount'],
                'comment'=>$data['comment']
            ];

            $transaction = $this->pointsDataFactory->create();
            $this->dataObjectHelper->populateWithArray(
                    $transaction,
                    $transactionData,
                    '\Exto\StoreCredit\Api\Data\PointsInterface'
            );
            
            $this->pointsRepository->save($transaction);

            //changing customer balance
            $customerBalance = $this->balanceRepository->loadByCustomerId($data['customer_id']);
            $balanceData = [
                'balance_id'=>$customerBalance->getBalanceId(),
                'store_id'=>$this->storeManager->getStore()->getId(),
                'customer_id'=>$data['customer_id'],
                'balance'=>$customerBalance->getBalance() + $data['amount'],
                'update_time'=>$this->dateTime->gmtDate()
            ];
            $balance = $this->balanceDataFactory->create();
            $this->dataObjectHelper->populateWithArray(
                    $balance,
                    $balanceData,
                    '\Exto\StoreCredit\Api\Data\BalanceInterface'
            );
            $this->balanceRepository->save($balance);
            return $result->setData(['success' => true]);
        } catch (\Magento\Framework\Validator\Exception $exception) {
            $this->logger->addDebug($exception->getMessage());
            return $result->setData(['success' => false,'error'=>$exception->getMessage()]);
        } catch (\Exception $exception) {
            $this->logger->addDebug($exception->getMessage());
            return $result->setData(['success' => false,'error'=>$exception->getMessage()]);
        }
    }
}