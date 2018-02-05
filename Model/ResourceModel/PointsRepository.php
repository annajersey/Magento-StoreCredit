<?php
namespace Exto\StoreCredit\Model\ResourceModel;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\InputException;

/**
 * Points repository.
 */
class PointsRepository implements \Exto\StoreCredit\Api\PointsRepositoryInterface
{
    /**
     * @var \Exto\StoreCredit\Model\PointsFactory
     */
    protected $transactionFactory;

    /**
     * @var \Exto\StoreCredit\Model\PointsRegistry
     */
    protected $transactionRegistry;

    /**
     * @var \Exto\StoreCredit\Model\ResourceModel\Points
     */
    protected $transactionResourceModel;

    /**
     * @var \Magento\Framework\Api\ExtensibleDataObjectConverter
     */
    protected $extensibleDataObjectConverter;

    /**
     * @param \Exto\StoreCredit\Model\PointsFactory $transactionFactory
     * @param \Exto\StoreCredit\Model\PointsRegistry $transactionRegistry
     * @param \Exto\StoreCredit\Model\ResourceModel\Points $transactionResourceModel
     * @param \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
     */
    public function __construct(
        \Exto\StoreCredit\Model\PointsFactory $transactionFactory,
        \Exto\StoreCredit\Model\PointsRegistry $transactionRegistry,
        \Exto\StoreCredit\Model\ResourceModel\Points $transactionResourceModel,
        \Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
    ) {
        $this->transactionFactory = $transactionFactory;
        $this->transactionRegistry = $transactionRegistry;
        $this->transactionResourceModel = $transactionResourceModel;
        // $this->searchResultsFactory = $searchResultsFactory;
        //$this->storeManager = $storeManager;
        $this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
    }
    
    /**
     * {@inheritdoc}
     */
    public function save(\Exto\StoreCredit\Api\Data\PointsInterface $transaction)
    {
        $this->validate($transaction);

        $transactionData = $this->extensibleDataObjectConverter->toNestedArray(
            $transaction,
            [],
            '\Exto\StoreCredit\Api\Data\PointsInterface'
        );

        $transactionModel = $this->transactionFactory->create(['data' => $transactionData]);
        $transactionModel->setId($transaction->getId());

        $this->transactionResourceModel->save($transactionModel);
        $this->transactionRegistry->push($transactionModel);
        $transactionId = $transactionModel->getId();

        $savedTransaction = $this->get($transactionId);

        return $savedTransaction;
    }
    
    /**
     * Validate transaction attribute values.
     *
     * @param \Exto\StoreCredit\Api\Data\PointsInterface $transaction
     * @throws InputException
     * @return void
     */
    private function validate(\Exto\StoreCredit\Api\Data\PointsInterface $transaction)
    {
        $exception = new InputException();

        if (!\Zend_Validate::is(trim($transaction->getAmount()), 'NotEmpty')) {
            $exception->addError(__(InputException::REQUIRED_FIELD, ['fieldName' => '`Amount`']));
        }

        if ($exception->wasErrorAdded()) {
            throw $exception;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function get($transactionId)
    {
        $transactionModel = $this->transactionRegistry->retrieve($transactionId);
        return $transactionModel->getDataModel();
    }
}
