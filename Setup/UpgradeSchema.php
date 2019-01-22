<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    const QUOTE_SHIPPING_RATE_TABLE_NAME = 'quote_shipping_rate';

    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;

        $installer->startSetup();
        if (version_compare($context->getVersion(), '2.2.101') < 0) {
            $this->updateQuoteShippingRateTable($installer);
        }
        $installer->endSetup();
    }

    /**
     * Update table 'quote_shipping_rate'
     *
     * @param object $installer
     */
    protected function updateQuoteShippingRateTable($installer)
    {
        $connection = $installer->getConnection();

        $connection->addColumn(
            $installer->getTable(self::QUOTE_SHIPPING_RATE_TABLE_NAME),
            'estimate',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 255,
                'nullable' => true,
                'comment' => 'Delivery estimate min days'
            ]
        );
        $connection->addColumn(
            $installer->getTable(self::QUOTE_SHIPPING_RATE_TABLE_NAME),
            'estimate_dates',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' => 'Delivery dates'
            ]
        );
        $connection->addColumn(
            $installer->getTable(self::QUOTE_SHIPPING_RATE_TABLE_NAME),
            'latitude',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 100,
                'nullable' => true,
                'comment' => 'Delivery pickpoint latitude'
            ]
        );
        $connection->addColumn(
            $installer->getTable(self::QUOTE_SHIPPING_RATE_TABLE_NAME),
            'longitude',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 100,
                'nullable' => true,
                'comment' => 'Delivery pickpoint longitude'
            ]
        );
    }
}
