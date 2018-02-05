<?php
namespace Exto\StoreCredit\Controller\Adminhtml\Transactions;

/**
 * Class Grid
 */
class Grid extends \Magento\Backend\App\Action
{
    /**
     * Transactions grid action
     *
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
        $resultLayout = $this->resultLayoutFactory->create();
        return $resultLayout;
    }
}