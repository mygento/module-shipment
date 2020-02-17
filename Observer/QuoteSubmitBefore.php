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
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $observer->getEvent()->getOrder()->getShippingAddress()->setDeliveryEstimate(
            $observer->getEvent()->getQuote()->getShippingAddress()->getDeliveryEstimate()
        );

        return $this;
    }
}
