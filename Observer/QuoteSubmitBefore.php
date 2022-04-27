<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
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
        if (!$observer->getEvent()->getQuote()->getShippingAddress() ||
            $observer->getEvent()->getQuote()->isVirtual()
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
