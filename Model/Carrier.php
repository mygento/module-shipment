<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

class Carrier implements \Mygento\Shipment\Api\Carrier\BaseInterface
{
    /**
     * @var \Mygento\Shipment\Api\Data\CalculateRequestInterfaceFactory
     */
    private $calculateFactory;

    /**
     * @var \Mygento\Shipment\Helper\Data
     */
    private $helper;

    /**
     * @var \Magento\Shipping\Model\Rate\ResultFactory
     */
    private $rateResultFactory;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;

    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    private $rateMethodFactory;

    /**
     * @param \Mygento\Shipment\Helper\Data $helper
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Mygento\Shipment\Api\Data\CalculateRequestInterfaceFactory $calculateFactory
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     */
    public function __construct(
        \Mygento\Shipment\Helper\Data $helper,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Mygento\Shipment\Api\Data\CalculateRequestInterfaceFactory $calculateFactory,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
    ) {
        $this->helper = $helper;
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->checkoutSession = $checkoutSession;
        $this->calculateFactory = $calculateFactory;
    }

    /**
     * @return \Magento\Shipping\Model\Rate\Result
     */
    public function getResult()
    {
        return $this->rateResultFactory->create();
    }

    /**
     * @return \Magento\Quote\Model\Quote\Address\RateResult\Method
     */
    public function getRateMethod()
    {
        return $this->rateMethodFactory->create();
    }

    /**
     * @return \Mygento\Shipment\Api\Data\CalculateRequestInterface
     */
    public function getCalculateRequest()
    {
        return $this->calculateFactory->create();
    }

    /**
     * @return float
     */
    public function getCartTotal()
    {
        $quote = $this->helper->getCurrentQuote();
        $totals = $quote->getTotals();
        $subtotal = $totals['subtotal']->getValue();
        if (isset($totals['discount'])) {
            $subtotal = $subtotal + $totals['discount']->getValue();
        }

        return $subtotal;
    }
}
