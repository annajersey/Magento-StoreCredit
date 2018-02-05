<?php 

namespace Exto\StoreCredit\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * Customer setup factory
     *
     * @var \Magento\Customer\Setup\CustomerSetupFactory
     */
    private $customerSetupFactory;
    
    /**
     * Init function
     *
     * @var \Magento\Customer\Setup\CustomerSetupFactory
     */
    public function __construct(\Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory)
    {
        $this->customerSetupFactory = $customerSetupFactory;
    }
    
    /**
     * Upgrade data function
     *
     * @var ModuleDataSetupInterface
     * @var ModuleContextInterface
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        
        if (version_compare($context->getVersion(), '0.2.4') == 0) {


            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
            $customerSetup->removeAttribute(\Magento\Customer\Model\Customer::ENTITY, "store_credit");
        }

        
                
        $setup->endSetup();
    }
}