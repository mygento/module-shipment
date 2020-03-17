<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Block\Adminhtml\Order;

class Estimate extends \Magento\Sales\Block\Adminhtml\Order\Create\Shipping\Method\Form
{
    /**
     * @var \Magento\Framework\Serialize\SerializerInterface
     */
    private $serializer;

    /**
     * @param \Magento\Framework\Serialize\SerializerInterface $serializer
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Model\Session\Quote $sessionQuote
     * @param \Magento\Sales\Model\AdminOrder\Create $orderCreate
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     * @param \Magento\Tax\Helper\Data $taxData
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Serialize\SerializerInterface $serializer,
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Model\Session\Quote $sessionQuote,
        \Magento\Sales\Model\AdminOrder\Create $orderCreate,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Tax\Helper\Data $taxData,
        array $data = []
    ) {
        parent::__construct($context, $sessionQuote, $orderCreate, $priceCurrency, $taxData, $data);
        $this->serializer = $serializer;
    }

    /**
     * @param string $date
     * @return bool
     */
    public function isDateActive(string $date): bool
    {
        return $this->getAddress()->getExtensionAttributes()->getDeliveryDate() === $date;
    }

    /**
     * @return string|null
     */
    public function getActiveDate()
    {
        return $this->getAddress()->getExtensionAttributes()->getDeliveryDate();
    }

    /**
     * @param string $from
     * @param string $to
     * @return bool
     */
    public function isTimeActive(string $from, string $to): bool
    {
        $actual = implode('-', [
            $this->getAddress()->getExtensionAttributes()->getDeliveryTimeFrom(),
            $this->getAddress()->getExtensionAttributes()->getDeliveryTimeTo(),
        ]);

        return $actual === implode('-', [$from, $to]);
    }

    /**
     * @return array
     */
    public function getEstimates(): array
    {
        $rate = $this->getActiveMethodRate();
        if (!$rate) {
            return [];
        }
        if (!$rate->getEstimateDate()) {
            return [];
        }

        try {
            return $this->serializer->unserialize($rate->getEstimateDate());
        } catch (Exception $e) {
            unset($e);

            return [];
        }
    }

    /**
     * @return array
     */
    public function getEstimatesTime(): array
    {
        $rate = $this->getActiveMethodRate();
        if (!$rate) {
            return [];
        }
        if (!$rate->getEstimateDate()) {
            return [];
        }

        if (!$rate->getEstimateTime()) {
            return [];
        }

        try {
            return $this->serializer->unserialize($rate->getEstimateTime());
        } catch (\Exception $e) {
            unset($e);

            return [];
        }
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if (empty($this->getEstimates())) {
            return '';
        }

        return parent::_toHtml();
    }
}
