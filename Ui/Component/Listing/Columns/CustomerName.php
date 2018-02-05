<?php

namespace Exto\StoreCredit\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Customer\Api\CustomerRepositoryInterface;
/**
 * Class Date
 */
class CustomerName extends Column
{
    /**
     * @var \Magento\Customer\Model\CustomerRepositoryInterface
     */
    protected $customerRepository;

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
        CustomerRepositoryInterface $customerRepository,
        array $components = [],
        array $data = []
    ) {
        $this->customerRepository = $customerRepository;
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
            $customer = $this->customerRepository->getById($item['customer_id']);
            $name = $customer ? $customer->getFirstName().' <'.$customer->getEmail().'>' : '';
            $item[$fieldName] = $name;
        }
        return $dataSource;
    }
}
