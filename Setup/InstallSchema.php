<?php
namespace Exto\StoreCredit\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Stdlib\DateTime\DateTimeFactory;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $table = $installer->getConnection()
            ->newTable($installer->getTable('exto_points_transactions'))
            ->addColumn(
                'transaction_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Id'
            )
            ->addColumn(
                'store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'StoreId'
            )
            ->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'CustomerId'
            )
            ->addColumn(
                'admin_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => true],
                'AdminId'
            )
            ->addColumn(
                'order_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => true],
                'AdminId'
            )
            ->addColumn(
                'amount',
                \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                null,
                ['unsigned' => false, 'nullable' => true,'default' => 0],
                'PointAmount'
            )
            ->addColumn(
                'actiondate',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Action Date'
            )
            ->addColumn(
                'comment',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                500,
                ['nullable' => true, 'default' => ''],
                'Comment'
            )
            ->addIndex(
                $installer->getIdxName(
                    'transactions_customer_id',
                    ['customer_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
                ),
                ['customer_id'],
                ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX]
            )  
                
            ->addForeignKey(
                'EXTO_STORECREDIT_CUSTOMER_TRANSACTIONS_TO_CUSTOMER',
                'customer_id',
                $installer->getTable('customer_entity'),
                'entity_id',
                \Magento\Framework\DB\Adapter\AdapterInterface::FK_ACTION_CASCADE
            )     
           ;    
                
                
        $installer->getConnection()->createTable($table);

        $balanceTable = $installer->getConnection()
            ->newTable($installer->getTable('exto_points_balance'))
            ->addColumn(
                'balance_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'BalanceId'
            )
            ->addColumn(
                'customer_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false], 
                'CustomerId'
            )
            ->addColumn(
                'store_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => false],
                'StoreId'
            )
            
            ->addColumn(
                'balance',
                \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                null,
                ['unsigned' => false, 'nullable' => true,'default' => 0],
                'Balance'
            )
            ->addColumn(
                'creation_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Creation Time'
            )->addColumn(
                'update_time',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                [],
                'Modification Time'
            )->addColumn(
                'is_active',
                \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                null,
                ['nullable' => false,'default' => '1'],
                'Is Active'
            )->addIndex(
                $installer->getIdxName(
                    'balance_customer_id',
                    ['customer_id'],
                    \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ['customer_id'],
                ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
            )
                
              
            ->addForeignKey(
                'EXTO_STORECREDIT_CUSTOMER_BALANSE_TO_CUSTOMER',
                'customer_id',
                $installer->getTable('customer_entity'),
                'entity_id',
                \Magento\Framework\DB\Adapter\AdapterInterface::FK_ACTION_CASCADE
            )    
            ;
            $installer->getConnection()->createTable($balanceTable);
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $datetimeFactory = new DateTimeFactory($objectManager);
            $datetime = $datetimeFactory->create();
            $setup->getConnection()->query(
                    'insert into '.$setup->getTable('exto_points_balance').
                    ' (store_id, customer_id, balance, creation_time) select store_id,'
                    . ' entity_id, 0, created_at from '.$setup->getTable('customer_entity').
                    ' on duplicate key update update_time="'.$datetime->gmtDate().'"');
            $trigger = new \Magento\Framework\DB\Ddl\Trigger;
            $setup->getConnection()->dropTrigger('exto_store_credit_customer_insert');
            $trigger->setName('exto_store_credit_customer_insert')
                ->setTime(\Magento\Framework\DB\Ddl\Trigger::TIME_AFTER)
                ->setEvent(\Magento\Framework\DB\Ddl\Trigger::EVENT_INSERT)
                ->setTable($setup->getTable('customer_entity'))
                ->addStatement(
                        'insert into '.$setup->getTable('exto_points_balance').
                        ' set store_id=NEW.store_id, customer_id=NEW.entity_id,'
                        . ' balance=0, creation_time=NEW.created_at;');
            $setup->getConnection()->createTrigger($trigger);
            
         $installer->endSetup();
    }
}
