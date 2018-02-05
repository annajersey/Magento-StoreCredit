<?php
namespace Exto\StoreCredit\Model;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Registry for \Exto\StreCredit\Model\Points
 */
class PointsRegistry
{
    const REGISTRY_SEPARATOR = ':';

    /**
     * @var pointsFactory
     */
    private $pointsFactory;

    /**
     * @var array
     */
    private $transactionRegistryById = [];

    /**
     * Constructor
     *
     * @param PointsFactory $pointsFactory
     */
    public function __construct(
        PointsFactory $pointsFactory
    ) {
        $this->pointsFactory = $pointsFactory;
    }

    /**
     * Retrieve points model from registry given an id
     *
     * @param string $transactionId
     * @return Transaction
     * @throws NoSuchEntityException
     */
    public function retrieve($transactionId)
    {
        if (isset($this->transactionRegistryById[$transactionId])) {
            return $this->transactionRegistryById[$transactionId];
        }

        /** @var Points $transaction */
        $transaction = $this->pointsFactory->create()->load($transactionId);

        if (!$transaction->getId()) {
            // transaction does not exist
            throw NoSuchEntityException::singleField('transactionId', $transactionId);
        } else {
            $this->transactionRegistryById[$transactionId] = $transaction;
            return $transaction;
        }
    }

    /**
     * Remove instance of the points model from registry given an id
     *
     * @param int $transactionId
     * @return void
     */
    public function remove($transactionId)
    {
        if (isset($this->transactionRegistryById[$transactionId])) {
            unset($this->transactionRegistryById[$transactionId]);
        }
    }

    /**
     * Replace existing points model with a new one.
     *
     * @param Points $transaction
     * @return $this
     */
    public function push(Points $transaction)
    {
        $this->transactionRegistryById[$transaction->getId()] = $transaction;
        return $this;
    }
}

