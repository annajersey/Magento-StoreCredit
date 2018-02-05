<?php
namespace Exto\StoreCredit\Api;

/**
 * Points CRUD interface.
 */
interface PointsRepositoryInterface
{
    /**
     * Create transaction.
     *
     * @api
     * @param \Exto\StoreCredit\Api\Data\PointsInterface $transaction
     * @return \Exto\StoreCredit\Api\Data\PointsInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\State\InputMismatchException If the provided ID is already used
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Exto\StoreCredit\Api\Data\PointsInterface $transaction);

    
    /**
     * Retrieve transaction.
     *
     * @api
     * @param string $transactionId
     * @return \Exto\StoreCredit\Api\Data\PointsInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If transaction with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($transactionId);
    
}

