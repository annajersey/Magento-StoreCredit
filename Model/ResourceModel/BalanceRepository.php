<?php
namespace Exto\StoreCredit\Model\ResourceModel;

use Magento\Framework\Exception\InputException;

/**
 * Balance repository.
 */
class BalanceRepository implements \Exto\StoreCredit\Api\BalanceRepositoryInterface
{
    /**
     * @var \Exto\StoreCredit\Model\BalanceFactory
     */
    protected $balanceFactory;

    /**
     * @var \Exto\StoreCredit\Model\BalanceRegistry
     */
    protected $balanceRegistry;

    /**
     * @var \Exto\StoreCredit\Model\ResourceModel\Balance
     */
    protected $balanceResourceModel;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\Api\ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    protected $balanceModel;
    /**
     * @param \Exto\StoreCredit\Model\BalanceFactory $balanceFactory
     * @param \Exto\StoreCredit\Model\BalanceRegistry $balanceRegistry
     * @param \Exto\StoreCredit\Model\ResourceModel\Balance $balanceResourceModel
     * @param \Exto\StoreCredit\Model\Balance $balanceModel
     * @param \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        \Exto\StoreCredit\Model\BalanceFactory $balanceFactory,
        \Exto\StoreCredit\Model\BalanceRegistry $balanceRegistry,
        \Exto\StoreCredit\Model\ResourceModel\Balance $balanceResourceModel,
        \Exto\StoreCredit\Model\Balance $balanceModel,
        //\Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->balanceFactory = $balanceFactory;
        $this->balanceRegistry = $balanceRegistry;
        $this->balanceResourceModel = $balanceResourceModel;
        $this->balanceModel = $balanceModel;
        //$this->storeManager = $storeManager;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }

    /**
     * {@inheritdoc}
     */
    public function save(\Exto\StoreCredit\Api\Data\BalanceInterface $balance)
    {
        $this->validate($balance);

        $balanceData = $this->extensibleDataObjectConverter->toNestedArray(
            $balance,
            [],
            '\Exto\StoreCredit\Api\Data\BalanceInterface'
        );

        $balanceModel = $this->balanceFactory->create(['data' => $balanceData]);
        $balanceModel->setBalanceId($balance->getBalanceId());

        $this->balanceResourceModel->save($balanceModel);
        $this->balanceRegistry->push($balanceModel);
        $balanceId = $balanceModel->getBalanceId();

        $savedBalance = $this->get($balanceId);

        return $savedBalance;
    }

    /**
     * Validate balance attribute values.
     *
     * @param \Exto\StoreCredit\Api\Data\BalanceInterface $balance
     * @throws InputException
     * @return void
     */
    private function validate(\Exto\StoreCredit\Api\Data\BalanceInterface $balance)
    {
        $exception = new InputException();

        if (!\Zend_Validate::is(trim($balance->getCustomerId()), 'NotEmpty')) {
            $exception->addError(__(InputException::REQUIRED_FIELD, ['fieldName' => '`Customer Id`']));
        }

        if ($exception->wasErrorAdded()) {
            throw $exception;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function get($balanceId)
    {
        $balanceModel = $this->balanceRegistry->retrieve($balanceId);
        return $balanceModel->getDataModel();
    }
    
    /**
     * Load balance by customer_id
     *
     * @param   int $customerId
     * @return  $this
     */
    public function loadByCustomerId($customerId)
    {
        $this->balanceResourceModel->loadByCustomerId($this->balanceModel, $customerId);
        return $this->balanceModel->getDataModel();
    }
}
