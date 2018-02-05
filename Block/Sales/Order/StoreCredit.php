<?php

/**
 * Tax totals modification block. Can be used just as subblock of \Magento\Sales\Block\Order\Totals
 */
namespace Exto\StoreCredit\Block\Sales\Order;

class StoreCredit extends \Magento\Framework\View\Element\Template
{
    /**
     * Tax configuration model
     *
     * @var \Magento\Tax\Model\Config
     */
    protected $config;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var \Magento\Framework\DataObject
     */
    protected $source;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Tax\Model\Config $taxConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Tax\Model\Config $taxConfig,
        array $data = []
    ) {
        $this->config = $taxConfig;
        parent::__construct($context, $data);
    }

    /**
     * Check if we nedd display full tax total info
     *
     * @return bool
     */
    public function displayFullSummary()
    {
        return true;
    }

    /**
     * Get data (totals) source model
     *
     * @return \Magento\Framework\DataObject
     */
    public function getSource()
    {
        return $this->source;
    }
    public function getStore()
    {
        return $this->order->getStore();
    }

      /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return array
     */
    public function getLabelProperties()
    {
        return $this->getParentBlock()->getLabelProperties();
    }

    /**
     * @return array
     */
    public function getValueProperties()
    {
        return $this->getParentBlock()->getValueProperties();
    }

    /**
     * Initialize all order totals relates with tax
     *
     * @return \Magento\Tax\Block\Sales\Order\Tax
     */
    public function initTotals()
    {
        $parent = $this->getParentBlock();
        $this->order = $parent->getOrder();
        $this->source = $parent->getSource();
        $store = $this->getStore();
        $storeCredit = new \Magento\Framework\DataObject(
            [
                'code' => 'store_credit',
                'strong' => false,
                'value' => -100,
                //'value' => $this->_source->getFee(),
                'label' => __('Store Credit'),
            ]
        );
        $parent->addTotal($storeCredit, 'store_credit');
        // $this->_addTax('grand_total');
        $parent->addTotal($storeCredit, 'store_credit');
        return $this;
    }
}