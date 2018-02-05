<?php
namespace Exto\StoreCredit\Controller\Adminhtml\Transactions;

/**
 * Class Index
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    
    /**
     * Transactions list action
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Forward
     */
    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->forward('grid');
            return $resultForward;
        }
        $resultPage = $this->resultPageFactory->create();

        /**
         * Set active menu item
         */
        $resultPage->setActiveMenu('Exto_StoreCredit::storecredit_menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Transactions'));

        /**
         * Add breadcrumb item
         */
        $resultPage->addBreadcrumb(__('Transactions'), __('Transactions'));
        $resultPage->addBreadcrumb(__('Manage Transactions'), __('Manage Transactions'));

        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Exto_StoreCredit::exto_store_credit_transactions_view');
    }
}
