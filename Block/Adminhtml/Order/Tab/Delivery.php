<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Block\Adminhtml\Order\Tab;

class Delivery extends \Magento\Backend\Block\Widget\Tab
{
    /**
     * @var \Mygento\Shipment\Helper\Data
     */
    protected $helper;

    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @param \Mygento\Shipment\Helper\Data $helper
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Mygento\Shipment\Helper\Data $helper,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->getTabTitle();
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle()
    {
        return strtoupper($this->helper->getCode());
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return $this->helper->isShippedBy($this->getOrder());
    }

    /**
     * Retrieve order model instance
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->coreRegistry->registry('current_order');
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getTabClass()
    {
        return 'ajax only';
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->getTabClass();
    }

    /**
     * @return string
     */
    public function getTabUrl()
    {
        return $this->getUrl(
            'mygento_' . $this->helper->getCode() . '/*/deliverytab',
            ['_current' => true]
        );
    }

    /**
     * @param string $action
     * @return string
     */
    public function getLink($action)
    {
        return $this->_urlBuilder->getUrl(
            'mygento_' . $this->helper->getCode() . '/delivery/' . $action,
            ['_secure' => true, 'order_id' => $this->getOrder()->getId()]
        );
    }
}
