<?php

namespace Exto\StoreCredit\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Date
 */
class CustomerBalance extends Column
{
    /**
     * @var Exto\StoreCredit\Api\BalanceRepositoryInterface
     */
    protected $balanceRepository;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param TimezoneInterface $timezone
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Exto\StoreCredit\Api\BalanceRepositoryInterface $balanceRepository,
        array $components = [],
        array $data = []
    ) {
        $this->balanceRepository = $balanceRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $fieldName = $this->getData('name');
        foreach ($dataSource['data']['items'] as & $item) {
            $customerBalance = $this->balanceRepository->loadByCustomerId($item['entity_id']);
            $currentBalance = $customerBalance ? $customerBalance->getBalance() : 0;
            $item[$fieldName] = number_format($currentBalance, 2, '.', ',');
        }
        return $dataSource;
    }
}
