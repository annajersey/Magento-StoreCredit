<?php

namespace Exto\StoreCredit\Controller\Adminhtml\Customer;

class BalanceGrid extends \Magento\Customer\Controller\Adminhtml\Index
{
    public function execute()
    {
        $this->initCurrentCustomer();
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}
