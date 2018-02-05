<?php
namespace Exto\StoreCredit\Model;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Registry for \Exto\StoreCredit\Model\Points
 */
class BalanceRegistry
{
    const REGISTRY_SEPARATOR = ':';

    /**
     * @var balanceFactory
     */
    private $balanceFactory;

    /**
     * @var array
     */
    private $balanceRegistryById = [];

    /**
     * Constructor
     *
     * @param BalanceFactory $balanceFactory
     */
    public function __construct(
        BalanceFactory $balanceFactory
    ) {
        $this->balanceFactory = $balanceFactory;
    }

    /**
     * Retrieve balance model from registry given an id
     *
     * @param string $balanceId
     * @return Balance
     * @throws NoSuchEntityException
     */
    public function retrieve($balanceId)
    {
        if (isset($this->balanceRegistryById[$balanceId])) {
            return $this->balanceRegistryById[$balanceId];
        }

        /** @var Balance $balance */
        $balance = $this->balanceFactory->create()->load($balanceId);

        if (!$balance->getId()) {
            // balance does not exist
            //throw NoSuchEntityException::singleField('balanceId', $balanceId);
            return null;
        } else {
            $this->balanceRegistryById[$balanceId] = $balance;
            return $balance;
        }
    }
    
    /**
     * Remove instance of the balance model from registry given an id
     *
     * @param int $balanceId
     * @return void
     */
    public function remove($balanceId)
    {
        if (isset($this->balanceRegistryById[$balanceId])) {
            unset($this->balanceRegistryByIdRegistryById[$balanceId]);
        }
    }

    /**
     * Replace existing balance model with a new one.
     *
     * @param Balance $balance
     * @return $this
     */
    public function push(Balance $balance)
    {
        $this->balanceRegistryById[$balance->getId()] = $balance;
        return $this;
    }



}

