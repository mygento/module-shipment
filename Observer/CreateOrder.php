<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Observer;

class CreateOrder implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Framework\App\RequestInterface $request */
        $request = $observer->getEvent()->getRequest();
        /** @var \Magento\Sales\Model\AdminOrder\Create $model */
        $model = $observer->getEvent()->getOrderCreateModel();
        $quote = $model->getQuote();

        if (!$quote->getShippingAddress()) {
            return;
        }

        $extensionAttributes = $quote->getShippingAddress()->getExtensionAttributes();
        $data = $request['estimate'] ?? false;
        if (!$data) {
            $extensionAttributes->setDeliveryDate(null);
            $extensionAttributes->setDeliveryTimeFrom(null);
            $extensionAttributes->setDeliveryTimeTo(null);
            $quote->getShippingAddress()->setExtensionAttributes($extensionAttributes);

            return;
        }

        $extensionAttributes->setDeliveryDate($data['date'] ?? null);
        $extensionAttributes->setDeliveryTimeFrom($data['time_from'] ?? null);
        $extensionAttributes->setDeliveryTimeTo($data['time_to'] ?? null);
        $quote->getShippingAddress()->setExtensionAttributes($extensionAttributes);
    }
}
