<?php

/**
 * @author Mygento Team
 * @copyright 2016-2018 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

class Carrier
{
    private $helper;
    private $rateResultFactory;
    private $checkoutSession;

    /**
     * @var \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory
     */
    private $rateMethodFactory;

    public function __construct(
        \Mygento\Shipment\Helper\Data $helper,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        $this->helper = $helper;
        $this->rateResultFactory = $rateResultFactory;
        $this->rateMethodFactory = $rateMethodFactory;
        $this->checkoutSession = $checkoutSession;
    }

    public function getResult()
    {
        return $this->rateResultFactory->create();
    }

    /**
     *
     * @return \Magento\Quote\Model\Quote\Address\RateResult\Method
     */
    public function getRateMethod()
    {
        return $this->rateMethodFactory->create();
    }

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
