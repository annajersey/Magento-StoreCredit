<?php

namespace Exto\StoreCredit\Controller\Adminhtml\Customer;
 
class Balance extends \Magento\Customer\Controller\Adminhtml\Index
{
    
    
    /**
     * Customer store credit tab
     *
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $this->initCurrentCustomer();
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
    
}


