<?php

/**
 * @author Mygento Team
 * @copyright 2016-2021 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Carrier\AbstractCarrier as BaseCarrier;
use Mygento\Shipment\Api\Carrier\AbstractCarrierInterface;
use Mygento\Shipment\Api\Data\CalculateResultInterface;
use Mygento\Shipment\Api\DimensionInterface;

abstract class AbstractCarrier extends BaseCarrier implements AbstractCarrierInterface
{
    /**
     * @var \Mygento\Shipment\Model\Carrier
     */
    protected $baseCarrier;

    /**
     * @var \Mygento\Shipment\Helper\Data
     */
    protected $helper;

    /**
     * @param \Mygento\Shipment\Model\Carrier $baseCarrier
     * @param \Mygento\Shipment\Helper\Data $helper
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        \Mygento\Shipment\Model\Carrier $baseCarrier,
        \Mygento\Shipment\Helper\Data $helper,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        array $data = []
    ) {
        $this->helper = $helper;
        $this->baseCarrier = $baseCarrier;

        parent::__construct(
            $scopeConfig,
            $rateErrorFactory,
            $logger,
            $data
        );
    }

    /**
     * @param \Magento\Quote\Model\Quote\Address\RateRequest $request
     * @return mixed
     */
    public function convertWeight(RateRequest $request)
    {
        return $request->getPackageWeight()
            * (float) $this->getConfigData(DimensionInterface::WEIGHT);
    }

    /**
     * @param \Magento\Quote\Model\Quote\Address\RateRequest $request
     * @param int $mode
     * @return string
     */
    public function convertCity(RateRequest $request, $mode = MB_CASE_TITLE): string
    {
        return mb_convert_case(trim($request->getDestCity()), $mode, 'UTF-8');
    }

    /**
     * Создание метода доставки
     *
     * @param \Mygento\Shipment\Api\Data\CalculateResultInterface $method
     */
    public function createRateMethod(CalculateResultInterface $method)
    {
        if ($method->getError()) {
            return $this->returnError($method->getErrorMessage());
        }

        $rate = $this->getRateMethod();

        $rate->setCarrier($method->getCarrier());
        $rate->setCarrierTitle($method->getCarrierTitle());
        $rate->setMethod($method->getMethod());
        $rate->setMethodTitle($method->getMethodTitle());
        $rate->setPrice($method->getPrice());
        $rate->setCost($method->getCost());

        $rate->setEstimateDate($method->getEstimateDate());
        $rate->setEstimateTime($method->getEstimateTime());
        $rate->setEstimate($method->getEstimate());

        $rate->setPickupPoints($method->getPickupPoints());
        $rate->setDescription($method->getDescription());

        // deprecated
        $rate->setLatitude($method->getLatitude());
        $rate->setLongitude($method->getLongitude());

        return $rate;
    }

    /**
     * @return bool
     */
    public function isTrackingAvailable(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function getAllowedMethods(): array
    {
        return [];
    }

    /**
     * @return bool
     */
    public function isCityRequired(): bool
    {
        return true;
    }

    /**
     * Validate shipping request before processing
     * @param \Magento\Quote\Model\Quote\Address\RateRequest $request
     * @return bool|\Magento\Quote\Model\Quote\Address\RateResult\Error
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
            $request->setPackageWeight((float) $this->helper->getConfig('defaultweight'));
            $this->helper->debug('Set default weight: ' . $request->getPackageWeight());
        }
        $this->helper->debug('Weight: ' . $request->getPackageWeight());
        if (0 >= $request->getPackageWeight()) {
            return $this->returnError('Zero weight');
        }

        return true;
    }

    /**
     * @return float
     */
    protected function getCartTotal()
    {
        return $this->baseCarrier->getCartTotal();
    }

    /**
     * @return mixed
     */
    protected function getResult()
    {
        return $this->baseCarrier->getResult();
    }

    /**
     * @return \Magento\Quote\Model\Quote\Address\RateResult\Method
     */
    protected function getRateMethod()
    {
        return $this->baseCarrier->getRateMethod();
    }

    /**
     * @return \Mygento\Shipment\Api\Data\CalculateRequestInterface
     */
    protected function getCalculateRequest()
    {
        return $this->baseCarrier->getCalculateRequest();
    }

    /**
     * @return \Magento\Shipping\Model\Tracking\Result\Status
     */
    protected function getTrackingResultStatus()
    {
        return $this->baseCarrier->getTrackingResult();
    }

    /**
     * @param string $message
     * @return bool|\Magento\Quote\Model\Quote\Address\RateResult\Error
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
     * @param \Magento\Quote\Model\Quote\Address\RateRequest $request
     * @return string|null
     */
    protected function getPostCode(RateRequest $request)
    {
        $postcode = $request->getDestPostcode();
        if ($postcode && $postcode != '') {
            $digitsOnlyPostcode = preg_replace('/[^0-9]/', '', $postcode);
            if ($digitsOnlyPostcode && $digitsOnlyPostcode != '') {
                return $digitsOnlyPostcode;
            }
        }

        return null;
    }
}
