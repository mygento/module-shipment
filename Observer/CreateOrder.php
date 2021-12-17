<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Observer;

class CreateOrder implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
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

        if (isset($request['order']['estimate'])) {
            $split = explode('-', $request['order']['estimate']['time'] ?? '');
            $request['order']['estimate']['time_from'] = $split[0] ?? null;
            $request['order']['estimate']['time_to'] = $split[1] ?? null;
            $this->setValue($quote, $request['order']['estimate']);

            return;
        }

        if (isset($request['order']['shipping_method']) || isset($request['collect_shipping_rates'])) {
            $extensionAttributes = $quote->getShippingAddress()->getExtensionAttributes();
            $extensionAttributes->setDeliveryDate(null);
            $quote->getShippingAddress()->setDeliveryDate(null);

            $extensionAttributes->setDeliveryTimeFrom(null);
            $quote->getShippingAddress()->setDeliveryTimeFrom(null);

            $extensionAttributes->setDeliveryTimeTo(null);
            $quote->getShippingAddress()->setDeliveryTimeTo(null);

            $quote->getShippingAddress()->setExtensionAttributes($extensionAttributes);

            return;
        }

        if (!isset($request['estimate'])) {
            return;
        }

        $this->setValue($quote, $request['estimate']);
    }

    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param array $data
     */
    private function setValue($quote, array $data)
    {
        $extensionAttributes = $quote->getShippingAddress()->getExtensionAttributes();
        $extensionAttributes->setDeliveryDate($data['date'] ?? null);
        $quote->getShippingAddress()->setDeliveryDate($data['date'] ?? null);

        $extensionAttributes->setDeliveryTimeFrom($data['time_from'] ?? null);
        $quote->getShippingAddress()->setDeliveryTimeFrom($data['time_from'] ?? null);

        $extensionAttributes->setDeliveryTimeTo($data['time_to'] ?? null);
        $quote->getShippingAddress()->setDeliveryTimeTo($data['time_to'] ?? null);

        $quote->getShippingAddress()->setExtensionAttributes($extensionAttributes);
    }
}
