<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Block\Adminhtml\Order;

class DeliveryDatetime extends \Magento\Sales\Block\Adminhtml\Order\AbstractOrder
{
    /**
     * Prepare html output
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->getOrder()->getShippingAddress()) {
            return parent::_toHtml();
        }

        return parent::_toHtml();
    }
}
