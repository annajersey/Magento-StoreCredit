<?php
namespace Exto\StoreCredit\Api;

/**
 * Balance CRUD interface.
 */
interface BalanceRepositoryInterface
{
    /**
     * Create balance.
     *
     * @api
     * @param \Exto\StoreCredit\Api\Data\BalanceInterface $balance
     * @return \Exto\StoreCredit\Api\Data\BalanceInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided ID is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Exto\StoreCredit\Api\Data\BalanceInterface $balance);


    /**
     * Retrieve balance.
     *
     * @api
     * @param string $balanceId
     * @return \Exto\StoreCredit\Api\Data\BalanceInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If balance with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($balanceId);
    
}

