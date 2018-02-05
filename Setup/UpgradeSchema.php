<?php

namespace Exto\StoreCredit\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Stdlib\DateTime\DateTimeFactory;

class UpgradeSchema implements  UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '0.0.0') == 0) {
            $setup->getConnection()->changeColumn(
                $setup->getTable('exto_points_balance'),
                'creation_time',
                'creation_time',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                    'comment' => 'Creation Time',
                    'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT,
                    'nullable' => false,
                ]
            );
            $setup->getConnection()->addIndex(
                $setup->getTable('exto_points_balance'),
                'balance_customer_id',
                ['customer_id'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
            );
        }
        if (version_compare($context->getVersion(), '0.0.1') == 0) {
            $setup->getConnection()->dropColumn(
                $setup->getTable('exto_points_balance'),
                'balance_id'
            );
            $setup->getConnection()->changeColumn(
                $setup->getTable('exto_points_balance'),
                'customer_id',
                'customer_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'default' => 0,
                    'nullable' => true,
                    'column_position' => 0,
                    'length' => 10,
                    'comment' => 'CustomerId'
                ]
            );
            $setup->getConnection()->dropIndex(
                $setup->getTable('exto_points_balance'),
                'balance_customer_id'
            );
            $setup->getConnection()->addIndex(
                $setup->getTable('exto_points_balance'),
                'PRIMARY',
                ['customer_id'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_PRIMARY
            );
            $setup->getConnection()->addIndex(
                $setup->getTable('exto_points_transactions'),
                'transactions_customer_id',
                ['customer_id'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_INDEX
            );
        }
        if (version_compare($context->getVersion(), '0.0.1') == 0) {
            $setup->getConnection()->changeColumn(
                $setup->getTable('exto_points_balance'),
                'customer_id',
                'customer_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'default' => 0,
                    'nullable' => true,
                    'column_position' => 0,
                    'length' => 10,
                    'comment' => 'CustomerId'
                ]
            );
            $setup->getConnection()->addForeignKey(
                'EXTO_STORECREDIT_CUSTOMER_BALANSE_TO_CUSTOMER',
                $setup->getTable('exto_points_balance'),
                'customer_id',
                $setup->getTable('customer_entity'),
                'entity_id',
                \Magento\Framework\DB\Adapter\AdapterInterface::FK_ACTION_CASCADE
            );
            $setup->getConnection()->addForeignKey(
                'EXTO_STORECREDIT_CUSTOMER_TRANSACTIONS_TO_CUSTOMER',
                $setup->getTable('exto_points_transactions'),
                'customer_id',
                $setup->getTable('customer_entity'),
                'entity_id',
                \Magento\Framework\DB\Adapter\AdapterInterface::FK_ACTION_CASCADE
            );
        }
        if (version_compare($context->getVersion(), '0.0.1') == 0) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $datetimeFactory = new DateTimeFactory($objectManager);
            $datetime = $datetimeFactory->create();
            $setup->getConnection()->query(
                    'insert into '.$setup->getTable('exto_points_balance').
                    ' (store_id, customer_id, balance, creation_time) select store_id,'
                    . ' entity_id, 0, created_at from '.$setup->getTable('customer_entity').
                    ' on duplicate key update update_time="'.$datetime->gmtDate().'"');
            $trigger = new \Magento\Framework\DB\Ddl\Trigger;
            $trigger->setName('exto_store_credit_customer_insert')
                ->setTime(\Magento\Framework\DB\Ddl\Trigger::TIME_AFTER)
                ->setEvent(\Magento\Framework\DB\Ddl\Trigger::EVENT_INSERT)
                ->setTable($setup->getTable('customer_entity'))
                ->addStatement(
                'insert into '.$setup->getTable('exto_points_balance').
                ' set store_id=NEW.store_id, customer_id=NEW.entity_id,'
                . ' balance=0, creation_time=NEW.created_at;');
            $setup->getConnection()->createTrigger($trigger);
        }
        if (version_compare($context->getVersion(), '0.0.2') == 0) {
                $setup->getConnection()->dropIndex(
                $setup->getTable('exto_points_balance'),
                'PRIMARY'
                );
                
                $column = [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                'length' => 11,
                'nullable' => false,
                'comment' => 'Balance Id',
                'primary' => true,
                'auto_increment' => true,
                ];
            
                $setup->getConnection()->addColumn($setup->getTable('exto_points_balance'), 'balance_id', $column);
                $setup->getConnection()->changeColumn(
                $setup->getTable('exto_points_balance'),
                'balance',
                'balance',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'default' => 0,
                    'nullable' => true,
                    'unsigned' => false,
                    'length' => '12,2',
                    'comment' => 'Balance'
                ]
                );
                $setup->getConnection()->changeColumn(
                $setup->getTable('exto_points_transactions'),
                'amount',
                'amount',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    'default' => 0,
                    'nullable' => true,
                    'unsigned' => false,
                    'length' => '12,2',
                    'comment' => 'Transaction Amount'
                ]
                );
        }
        $setup->endSetup();
    }
}