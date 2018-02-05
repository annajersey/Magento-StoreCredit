<?php
namespace Exto\StoreCredit\Block\Adminhtml\Edit\Customer\Tab\View;

class BalanceForm extends \Magento\Backend\Block\Widget\Form\Generic
{

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $systemStore;
    
    
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Init form
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('transaction_form');
        $this->setTitle(__('Balance Information'));
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            ['data' => [
                'id' => 'update-balance-form',
                'action' => $this->getUrl(
                        'exto_store_credit/customer/balanceupdate',
                        ['_current' => true]),
                        'method' => 'post'
                ]
            ]
        );

        $form->setHtmlIdPrefix('transaction_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            ['legend' => __('Update balance'), 'class' => 'fieldset-wide']
        );

       
        $balanceField = $fieldset->addField(
            'balance',
            'text',
            ['name' => 'balance', 
             'class' => 'validate-number',
             'label' => __('Balance change'), 
             'title' => __('Balance change'), 
             'required' => true,
             'note' => __('Enter positive to add, negative to subtract') 
            ]
        );
        
        $balanceField->addCustomAttribute('data-validate', "{'required-number':true}");

        
        
        $fieldset->addField(
            'comment',
            'textarea',
            [
                'name' => 'comment',
                'label' => __('Comment'),
                'title' => __('Comment'),
                'note' => __('Comment for customer') 
            ]
        );
        
        
        $fieldset->addField(
            'update_balance',
            'button',
             ['name' => 'update-balance', 'value' => __('Update Balance')]
        );
      
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
    
    
}

