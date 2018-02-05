<?php
namespace Exto\StoreCredit\Block\Adminhtml\Edit\Customer\Tab\View;

use Magento\Backend\Block\Template;
use Magento\Customer\Controller\RegistryConstants;

class AjaxForm extends Template
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry|null
     */
    protected $coreRegistry = null;
    
    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Magento\Framework\Registry $coreRegistry,    
        array $data = []
    ) {
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }
    
    /**
     * @return string|null
     */
    public function getCustomerId()
    {
        return $this->coreRegistry->registry(RegistryConstants::CURRENT_CUSTOMER_ID);
    }
    
    /**
     * @return string
     */
    public function getFormAction()
    {
        return $this->getUrl('exto_store_credit/customer/updatebalance', ['_current' => true]);
    }
    
    /**
     * @return string
     */
    public function getSuccessMessage()
    {
        return __('Customer balance was updated');
    }
    
    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return __('Something goes wrong');
    }
    
    
}