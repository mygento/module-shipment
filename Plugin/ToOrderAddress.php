<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Plugin;

use Magento\Quote\Model\Quote\Address;
use Magento\Sales\Api\Data\OrderAddressExtensionInterfaceFactory;
use Magento\Sales\Api\Data\OrderAddressInterface;

class ToOrderAddress
{
    /**
     * @var OrderAddressExtensionInterfaceFactory
     */
    private $addressExtensionFactory;

    /**
     * @param OrderAddressExtensionInterfaceFactory $addressExtensionFactory
     */
    public function __construct(OrderAddressExtensionInterfaceFactory $addressExtensionFactory)
    {
        $this->addressExtensionFactory = $addressExtensionFactory;
    }

    /**
     * @param \Magento\Quote\Model\Quote\Address\ToOrderAddress $subject
     * @param OrderAddressInterface $result
     * @param Address $address
     * @return OrderAddressInterface
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterConvert(
        Address\ToOrderAddress $subject,
        OrderAddressInterface $result,
        Address $address
    ) {
        if ($address->getAddressType() !== Address::ADDRESS_TYPE_SHIPPING) {
            return $result;
        }

        $extensionAttributes = $result->getExtensionAttributes() ?: $this->addressExtensionFactory->create();
        $extensionAttributes->setDeliveryDate($address->getDeliveryDate());
        $extensionAttributes->setDeliveryTimeFrom($address->getDeliveryTimeFrom());
        $extensionAttributes->setDeliveryTimeTo($address->getDeliveryTimeTo());
        $extensionAttributes->setDeliveryEstimate($address->getDeliveryEstimate());
        $extensionAttributes->setShipmentDate($address->getShipmentDate());
        $extensionAttributes->setPickupPoint($address->getPickupPoint());
        $result->setExtensionAttributes($extensionAttributes);

        return $result;
    }
}
