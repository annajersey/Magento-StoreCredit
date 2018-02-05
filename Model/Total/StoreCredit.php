<?php

namespace Exto\StoreCredit\Model\Total;


class StoreCredit extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * Collect grand total address amount
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this
     */

    /**
     * @var \Magento\Quote\Model\QuoteValidator
     */
    protected $quoteValidator = null;

    /**
     * @var \Exto\StoreCredit\Model\StoreCredit
     */
    protected $storeCredit;

    public function __construct(
        \Magento\Quote\Model\QuoteValidator $quoteValidator,
        \Exto\StoreCredit\Model\StoreCredit $storeCredit
    ) {
        $this->quoteValidator = $quoteValidator;
        $this->storeCredit = $storeCredit;
    }

    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);
        //$exist_amount = 0; //$quote->getFee();
        //$store_credit = 100; //Excellence_Fee_Model_Fee::getFee();
        //$balance = $store_credit - $exist_amount;
        $balance = $this->storeCredit->isPointsApplied();
        $balance *= -1;
        $total->setTotalAmount('store_credit', $balance);
        $total->setBaseTotalAmount('store_credit', $balance);
        $total->setDiscount($balance);
        $total->setBaseDiscount($balance);
        $total->setGrandTotal($total->getGrandTotal() - $balance);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() - $balance);
        return $this;
    }

    protected function clearValues(Address\Total $total)
    {
        $total->setTotalAmount('subtotal', 0);
        $total->setBaseTotalAmount('subtotal', 0);
        $total->setTotalAmount('tax', 0);
        $total->setBaseTotalAmount('tax', 0);
        $total->setTotalAmount('discount_tax_compensation', 0);
        $total->setBaseTotalAmount('discount_tax_compensation', 0);
        $total->setTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setBaseTotalAmount('shipping_discount_tax_compensation', 0);
        $total->setSubtotalInclTax(0);
        $total->setBaseSubtotalInclTax(0);
    }

    /**
     * Assign subtotal amount and label to address object
     *
     * @param \Magento\Quote\Model\Quote $quote
     * @param Address\Total $total
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $appliedPoints = $this->storeCredit->isPointsApplied();
        if ($appliedPoints) {
            return [
                'code' => 'store_credit',
                'title' => 'Store Credit',
                'value' => $appliedPoints
            ];
        } else {
            return [
                'code' => 'store_credit',
                'title' => 'Store Credit',
                'value' => $this->storeCredit->getCustomerPoints()
            ];
        }
    }

    /**
     * Get Subtotal label
     *
     * @return \Magento\Framework\Phrase
     */
    public function getLabel()
    {
        return __('Store Credit');
    }
}