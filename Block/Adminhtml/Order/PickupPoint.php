<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Block\Adminhtml\Order;

use Magento\Framework\Pricing\PriceCurrencyInterface;

class PickupPoint extends \Magento\Sales\Block\Adminhtml\Order\Create\Shipping\Method\Form
{
    /**
     * @var \Mygento\Shipment\Model\ResourceModel\Point\CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Model\Session\Quote $sessionQuote,
        \Magento\Sales\Model\AdminOrder\Create $orderCreate,
        PriceCurrencyInterface $priceCurrency,
        \Magento\Tax\Helper\Data $taxData,
        \Mygento\Shipment\Model\ResourceModel\Point\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $sessionQuote, $orderCreate, $priceCurrency, $taxData, $data);
        $this->collectionFactory = $collectionFactory;
    }

    public function getPoints()
    {
        $result = [];

        $rate = $this->getActiveMethodRate();

        if ($rate->getMethod() !== 'pvz') {
            return $result;
        }

        $regionId = (int) $this->getAddress()->getRegionCode();
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('region_id', $regionId);
        $collection->addFieldToFilter('city', $this->getAddress()->getCity());

        foreach ($collection as $point) {
            /**
             * @var \Mygento\Shipment\Model\Point
             */
            $result[$point->__toString()] = implode(
                ', ',
                [$point->getProvider(), $point->getAddress(), $point->getCity()]
            );
        }

        return $result;
    }

    public function isPointActive($pointKey)
    {
        return $this->getAddress()->getPickupPoint() === $pointKey;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if (empty($this->getPoints())) {
            return '';
        }

        return parent::_toHtml();
    }
}
