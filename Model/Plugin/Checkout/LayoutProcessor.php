<?php

namespace Exto\StoreCredit\Model\Plugin\Checkout;

class LayoutProcessor
{
    /**
     * @var \Exto\StoreCredit\Model\StoreCredit
     */
    protected $storeCredit;

    public function __construct(
        \Exto\StoreCredit\Model\StoreCredit $storeCredit
    ) {
        $this->storeCredit = $storeCredit;
    }

    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject, $jsLayout)
    {
        if ($this->storeCredit->isPointsApplied()) {
            $jsLayout['components']['checkout']['children']['sidebar']['children']['summary']['children']['totals']['children']['store_credit'] = [
                'component' => 'Exto_StoreCredit/js/view/checkout/cart/totals/store_credit',
                'config' => [
                    'customScope' => 'storeCredit',
                    'template' => 'Exto_StoreCredit/checkout/cart/totals/store_credit',
                    'id' => 'store_credit',
                    'title' => __('Store Credit'),
                ],
                'dataScope' => 'storeCredit.value',
                'label' => 'Store Credit',
                'provider' => 'checkoutProvider',
                'visible' => true,
                'validation' => [],
                'sortOrder' => 20,
                'id' => 'store_credit',
            ];
        } else {
            $jsLayout['components']['checkout']['children']['sidebar']['children']['summary']['children']['totals']['children']['store_credit'] = [
                'component' => 'Exto_StoreCredit/js/view/checkout/cart/totals/store_credit',
                'config' => [
                    'customScope' => 'storeCredit',
                    'template' => 'Exto_StoreCredit/checkout/cart/totals/store_credit_input',
                    'id' => 'store_credit',
                    'title' => __('Store Credit'),
                ],
                'dataScope' => 'storeCredit.value',
                'label' => 'Store Credit',
                'provider' => 'checkoutProvider',
                'visible' => true,
                'validation' => [],
                'sortOrder' => 20,
                'id' => 'store_credit',
            ];
        }
        return $jsLayout;
    }
}