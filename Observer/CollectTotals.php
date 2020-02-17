<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Observer;

class CollectTotals implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Quote\Api\Data\AddressExtensionFactory
     */
    private $extensionFactory;

    /**
     * @param \Magento\Quote\Api\Data\AddressExtensionFactory $extensionFactory
     */
    public function __construct(
        \Magento\Quote\Api\Data\AddressExtensionFactory $extensionFactory
    ) {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return type
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Quote\Model\Quote $quote */
        $quote = $observer->getEvent()->getQuote();
        $shippingAddress = $quote->getShippingAddress();

        if (!$shippingAddress || !$shippingAddress->getShippingMethod()) {
            return;
        }

        $extensionAttributes = $shippingAddress->getExtensionAttributes();
        if (!$extensionAttributes) {
            $extensionAttributes = $this->extensionFactory->create();
            $shippingAddress->setExtensionAttributes($extensionAttributes);
        }

        $rate = $shippingAddress->getShippingRateByCode($shippingAddress->getShippingMethod());
        if (!$rate) {
            return;
        }

        if ($rate->getEstimate()) {
            $extensionAttributes->setDeliveryEstimate($rate->getEstimate());
            $shippingAddress->setDeliveryEstimate($rate->getEstimate());
        }
        $shippingAddress->setExtensionAttributes($extensionAttributes);
    }
}
