<?php

/**
 * @author Mygento Team
 * @copyright 2016-2018 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\AbstractCarrier as BaseCarrier;
use Mygento\Shipment\Api\Carrier\AbstractCarrierInterface;

abstract class AbstractCarrier extends BaseCarrier implements AbstractCarrierInterface
{
    protected $carrier;
    protected $helper;

    public function __construct(
        \Mygento\Shipment\Helper\Data $helper,
        \Mygento\Shipment\Model\Carrier $carrier,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->carrier = $carrier;

        parent::__construct(
            $scopeConfig,
            $rateErrorFactory,
            $logger,
            $data
        );
    }

    /**
     * Validate shipping request before processing
     * @param \Magento\Quote\Model\Quote\Address\RateRequest $request
     * @return boolean
     */
    protected function validateRequest(RateRequest $request)
    {
        if (!$this->getConfigData('active')) {
            return false;
        }
        $this->helper->info('Started calculating to: ' . $request->getDestCity());
        if (strlen($request->getDestCity()) <= 2) {
            $this->helper->info('City strlen <= 2, aborting ...');
            return false;
        }
        if ($this->helper->getConfig('defaultweight')) {
            $request->setPackageWeight($this->helper->getConfig('defaultweight'));
            $this->helper->debug('Set default weight: ' . $request->getPackageWeight());
        }
        $this->helper->debug('Weight: ' . $request->getPackageWeight());
        if (0 >= $request->getPackageWeight()) {
            return $this->returnError('Zero weight');
        }
        return true;
    }

    /**
     *
     * @return number
     */
    protected function getCartTotal()
    {
        return $this->carrier->getCartTotal();
    }

    protected function getResult()
    {
        return $this->carrier->getResult();
    }

    /**
     *
     * @return \Magento\Quote\Model\Quote\Address\RateResult\Method
     */
    protected function getRateMethod()
    {
        return $this->carrier->getRateMethod();
    }

    /**
     *
     * @param \Magento\Quote\Model\Quote\Address\RateRequest $request
     * @return mixed
     */
    public function convertWeight(RateRequest $request)
    {
        return $request->getPackageWeight() * $this->getConfigData('weightunit');
    }

    /**
     *
     * @param \Magento\Quote\Model\Quote\Address\RateRequest $request
     * @param string $mode
     * @return string
     */
    public function convertCity(RateRequest $request, $mode = MB_CASE_TITLE): string
    {
        return mb_convert_case(trim($request->getDestCity()), $mode, 'UTF-8');
    }

    /**
     *
     * @param string $message
     * @return boolean | \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $error
     */
    protected function returnError($message)
    {
        if ($this->getConfigData('debug')) {
            $error = $this->_rateErrorFactory->create();
            $error->setCarrier($this->_code);
            $error->setCarrierTitle($this->getConfigData('title'));
            $error->setErrorMessage(__($message));
            return $error;
        }
        return false;
    }

    /**
     * Создание метода доставки
     *
     * @param array $method
     * @return \Magento\Quote\Model\Quote\Address\RateResult\Method
     */
    protected function createRateMethod(array $method)
    {
        $rate = $this->getRateMethod();

        $rate->setCarrier($method['code']);
        $rate->setCarrierTitle($method['title']);
        $rate->setMethod($method['method']);
        $rate->setMethodTitle($method['name']);
        $rate->setPrice($method['price']);
        $rate->setCost($method['cost']);

        if (isset($method['estimate'])) {
            $rate->setEstimate(date(
                'Y-m-d',
                strtotime('+' . $method['estimate'] . ' days')
            ));
        }

        if (isset($method['latitude'])) {
            $rate->setLatitude($method['latitude']);
        }

        if (isset($method['longitude'])) {
            $rate->setLatitude($method['longitude']);
        }

        return $rate;
    }

    /**
     *
     * @return boolean
     */
    public function isTrackingAvailable(): bool
    {
        return true;
    }

    /**
     *
     * @return array
     */
    public function getAllowedMethods(): array
    {
        return [];
    }

    /**
     *
     * @return boolean
     */
    public function isCityRequired(): bool
    {
        return true;
    }
}
