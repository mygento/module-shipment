<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Observer;

class QuoteSubmitBefore implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if (
            empty($observer->getEvent()->getQuote()->getShippingAddress()) ||
            empty($observer->getEvent()->getOrder()->getShippingAddress())
        ) {
            return;
        }
        $observer->getEvent()->getOrder()->getShippingAddress()->setDeliveryEstimate(
            $observer->getEvent()->getQuote()->getShippingAddress()->getDeliveryEstimate()
        );
        $observer->getEvent()->getOrder()->getShippingAddress()->setDeliveryDate(
            $observer->getEvent()->getQuote()->getShippingAddress()->getDeliveryDate()
        );
        $observer->getEvent()->getOrder()->getShippingAddress()->setDeliveryTimeFrom(
            $observer->getEvent()->getQuote()->getShippingAddress()->getDeliveryTimeFrom()
        );
        $observer->getEvent()->getOrder()->getShippingAddress()->setDeliveryTimeTo(
            $observer->getEvent()->getQuote()->getShippingAddress()->getDeliveryTimeTo()
        );
        $observer->getEvent()->getOrder()->getShippingAddress()->setShipmentDate(
            $observer->getEvent()->getQuote()->getShippingAddress()->getShipmentDate()
        );
        $observer->getEvent()->getOrder()->getShippingAddress()->setPickupPoint(
            $observer->getEvent()->getQuote()->getShippingAddress()->getPickupPoint()
        );
    }
}
