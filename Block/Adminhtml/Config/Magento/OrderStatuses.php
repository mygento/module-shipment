<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Block\Adminhtml\Config\Magento;

class OrderStatuses extends \Magento\Framework\View\Element\Html\Select
{
    /**
     * @var \Mygento\Base\Model\Source\Status
     */
    private $orderStatuses;

    /**
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Mygento\Base\Model\Source\Status $orderStatuses
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Mygento\Base\Model\Source\Status $orderStatuses,
        array $data = []
    ) {
        $this->orderStatuses = $orderStatuses;
        parent::__construct($context, $data);
    }

    /**
     * @inheridoc
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            $attributes = $this->orderStatuses->toOptionArray();
            foreach ($attributes as $attribute) {
                $this->addOption($attribute['value'], $attribute['label']);
            }
        }

        return parent::_toHtml();
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }
}
