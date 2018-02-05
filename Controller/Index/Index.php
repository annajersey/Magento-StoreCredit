<?php

namespace Exto\StoreCredit\Controller\Index;

use Magento\Framework\App\RequestInterface;

/**
 * Responsible for loading page content.
 *
 * This is a basic controller that only loads the corresponding layout file. It may duplicate other such
 * controllers, and thus it is considered tech debt. This code duplication will be resolved in future releases.
 */
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * Customer session
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /** @var \Magento\Framework\View\Result\PageFactory  */
    //protected $resultPageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        //\Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Customer\Model\Session $customerSession
    ) {
        //$this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
        $this->customerSession = $customerSession;
    }
    /**
     * Load the page defined in view/frontend/layout/storecredit_index_index.xml
     *
     * @return \Magento\Framework\View\Result\Page
     */
    //public function execute()
    //{
    //    return $this->resultPageFactory->create();
    //}

    /**
     * Check customer authentication for some actions
     *
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function dispatch(RequestInterface $request)
    {
        if (!$this->customerSession->authenticate()) {
            $this->_actionFlag->set('', 'no-dispatch', true);
        }
        return parent::dispatch($request);
    }
}