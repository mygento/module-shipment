<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Block\Adminhtml\Config\Carrier;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Mygento\Shipment\Block\Adminhtml\Config\Magento\OrderStatuses;

abstract class TrackStatuses extends AbstractFieldArray
{
    const CARRIER = 'carrier_status';
    const ORDER = 'order_status';

    /**
     * @var \Magento\Framework\View\Element\Html\Select
     */
    private $carrierStatuses = null;

    /**
     * @var OrderStatuses
     */
    private $orderStatuses = null;

    /**
     * Get block
     */
    abstract public function getCarrierStatusBlock(): string;

    /**
     * @inheritdoc
     */
    protected function _prepareToRender()
    {
        $this->addColumn(self::CARRIER, [
            'label' => __('Carrier Status'),
            'renderer' => $this->getCarrierStatusesRenderer(),
            'class' => 'required-entry',
        ]);
        $this->addColumn(self::ORDER, [
            'label' => __('Order Status'),
            'renderer' => $this->getOrderStatusesRenderer(),
            'class' => 'required-entry',
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Method');
    }

    /**
     * @inheritdoc
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $optionExtraAttr = [
            'option_' . $this->getCarrierStatusesRenderer()
                ->calcOptionHash($row->getData(self::CARRIER)) => 'selected="selected"',
            'option_' . $this->getOrderStatusesRenderer()
                ->calcOptionHash($row->getData(self::ORDER)) => 'selected="selected"',
        ];

        $row->setData(
            'option_extra_attrs',
            $optionExtraAttr
        );
    }

    /**
     * @return \Magento\Framework\View\Element\Html\Select
     */
    private function getCarrierStatusesRenderer()
    {
        if ($this->carrierStatuses === null) {
            $this->carrierStatuses = $this->getLayout()->createBlock(
                $this->getCarrierStatusBlock(),
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->carrierStatuses;
    }

    /**
     * @return OrderStatuses
     */
    private function getOrderStatusesRenderer()
    {
        if ($this->orderStatuses === null) {
            $this->orderStatuses = $this->getLayout()->createBlock(
                OrderStatuses::class,
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->orderStatuses;
    }
}
