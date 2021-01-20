<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Helper;

use Magento\Framework\Api\Filter;
use Mygento\Base\Api\ProductAttributeHelperInterface;

class Data extends \Mygento\Base\Helper\Data
{
    const XML_TEST = 'test';
    const XML_TAX_ENABLED = 'tax_options/tax';
    const XML_TAX_SAME_PRODUCT = 'tax_options/tax_same';
    const XML_TAX_ALL_PRODUCT = 'tax_options/tax_products';
    const XML_TAX_PRODUCT_ATTR = 'tax_options/tax_product_attr';
    const XML_TAX_SHIPPING = 'tax_options/tax_shipping';
    const XML_AUTO_SHIPPING = 'order_statuses/autoshipping';
    const XML_AUTO_SHIPPING_STATUSES = 'order_statuses/autoshipping_statuses';
    const XML_SHIPMENT_SUCCESS_STATUS = 'order_statuses/shipment_success_status';
    const XML_SHIPMENT_FAIL_STATUS = 'order_statuses/shipment_fail_status';
    const XML_SHIPMENT_TRACK_CHECK = 'order_statuses/track_check';
    const XML_SHIPMENT_TRACK_STATUSES = 'order_statuses/track_statuses';
    const XML_SHIPMENT_TRACK_MAPPING = 'order_statuses/track_mapping';
    const XML_MARKING = 'marking/enabled';
    const XML_MARKING_FLAG = 'marking/marking_flag';
    const XML_MARKING_FIELD = 'marking/marking_field';
    const XML_MARKING_REFUND = 'marking/marking_refund';

    /** @var \Magento\Checkout\Model\Session */
    protected $checkoutSession;

    /** @var string */
    protected $code = 'shipment';

    /** @var \Magento\Framework\Api\FilterBuilder */
    private $filterBuilder;

    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Framework\Api\FilterBuilder $filterBuilder
     * @param \Mygento\Base\Model\LogManager $logManager
     * @param \Magento\Framework\Encryption\Encryptor $encryptor
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Mygento\Base\Model\LogManager $logManager,
        \Magento\Framework\Encryption\Encryptor $encryptor,
        \Magento\Framework\App\Helper\Context $context
    ) {
        parent::__construct(
            $logManager,
            $encryptor,
            $context
        );
        $this->checkoutSession = $checkoutSession;
        $this->filterBuilder = $filterBuilder;
    }

    /**
     * @return \Magento\Quote\Model\Quote
     */
    public function getCurrentQuote()
    {
        return $this->checkoutSession->getQuote();
    }

    /**
     * @param string $path
     * @param string|null $scopeCode
     * @return string
     */
    public function getConfig($path, $scopeCode = null)
    {
        return parent::getConfig('carriers/' . $this->code . '/' . $path, $scopeCode);
    }

    /**
     * @param string $path
     * @param string|null $scopeCode
     * @return string
     */
    public function getDefaultConfig($path, $scopeCode = null)
    {
        $postfix = ProductAttributeHelperInterface::CONFIG_PATH_DEFAULT_SUFFIX;

        return $this->getConfig($path . $postfix, $scopeCode);
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @return bool
     */
    public function isShippedBy(\Magento\Sales\Model\Order $order)
    {
        return strpos($order->getShippingMethod(), $this->getCode() . '_') !== false;
    }

    /**
     * @return string
     */
    public function getCarrierCode(): string
    {
        return $this->getCode();
    }

    /**
     * @param mixed|null $scopeCode
     * @return bool
     */
    public function isTestMode($scopeCode = null): bool
    {
        return (bool) $this->getConfig(self::XML_TEST, $scopeCode);
    }

    /**
     * @param mixed|null $scopeCode
     * @return bool
     */
    public function isEnabledTax($scopeCode = null): bool
    {
        return (bool) $this->getConfig(self::XML_TAX_ENABLED, $scopeCode);
    }

    /**
     * @param mixed|null $scopeCode
     * @return bool
     */
    public function isSameTaxPerProduct($scopeCode = null): bool
    {
        return (bool) $this->getConfig(self::XML_TAX_SAME_PRODUCT, $scopeCode);
    }

    /**
     * @param mixed|null $scopeCode
     * @return mixed
     */
    public function getAllProductTax($scopeCode = null)
    {
        return $this->getConfig(self::XML_TAX_ALL_PRODUCT, $scopeCode);
    }

    /**
     * @param mixed|null $scopeCode
     * @return mixed
     */
    public function getProductTaxAttribute($scopeCode = null)
    {
        return $this->getConfig(self::XML_TAX_PRODUCT_ATTR, $scopeCode);
    }

    /**
     * @param mixed|null $scopeCode
     * @return mixed
     */
    public function getTaxForShipping($scopeCode = null)
    {
        return $this->getConfig(self::XML_TAX_SHIPPING, $scopeCode);
    }

    /**
     * @param mixed|null $scopeCode
     * @return bool
     */
    public function isEnabledAutoShipping($scopeCode = null): bool
    {
        return (bool) $this->getConfig(self::XML_AUTO_SHIPPING, $scopeCode);
    }

    /**
     * @param mixed|null $scopeCode
     * @return bool
     */
    public function isEnabledTrackCheck($scopeCode = null): bool
    {
        return (bool) $this->getConfig(self::XML_SHIPMENT_TRACK_CHECK, $scopeCode);
    }

    /**
     * @param mixed|null $scopeCode
     * @return array
     */
    public function getAutoShippingStatuses($scopeCode = null): array
    {
        return array_filter(explode(
            ',',
            $this->getConfig(self::XML_AUTO_SHIPPING_STATUSES, $scopeCode) ?: ''
        ));
    }

    /**
     * @param mixed|null $scopeCode
     * @return array
     */
    public function getTrackCheckStatuses($scopeCode = null): array
    {
        return array_filter(explode(
            ',',
            $this->getConfig(self::XML_SHIPMENT_TRACK_STATUSES, $scopeCode) ?: ''
        ));
    }

    /**
     * @param mixed|null $scopeCode
     * @return string
     */
    public function getTrackMapping($scopeCode = null): string
    {
        return $this->getConfig(self::XML_SHIPMENT_TRACK_MAPPING, $scopeCode) ?: '[]';
    }

    /**
     * @param int|string $scopeCode
     * @return bool|string
     */
    public function getShipmentFailStatus($scopeCode = null)
    {
        return $this->getConfig(self::XML_SHIPMENT_FAIL_STATUS, $scopeCode) ?: false;
    }

    /**
     * @param int|string $scopeCode
     * @return bool|string
     */
    public function getShipmentSuccessStatus($scopeCode = null)
    {
        return $this->getConfig(self::XML_SHIPMENT_SUCCESS_STATUS, $scopeCode) ?: false;
    }

    /**
     * @param mixed|null $scopeCode
     * @return bool
     */
    public function isEnabledMarking($scopeCode = null): bool
    {
        return (bool) $this->getConfig(self::XML_MARKING, $scopeCode);
    }

    /**
     * @param int|string $scopeCode
     * @return mixed
     */
    public function getMarkingFlag($scopeCode = null)
    {
        return $this->getConfig(self::XML_MARKING_FLAG, $scopeCode);
    }

    /**
     * @param int|string $scopeCode
     * @return mixed
     */
    public function getMarking($scopeCode = null)
    {
        return $this->getConfig(self::XML_MARKING_FIELD, $scopeCode);
    }

    /**
     * @param int|string $scopeCode
     * @return mixed
     */
    public function getMarkingRefund($scopeCode = null)
    {
        return $this->getConfig(self::XML_MARKING_REFUND, $scopeCode);
    }

    /**
     * @param string $field
     * @param array|string|null $value
     * @param string $condition
     * @return Filter[]
     */
    public function getCarrierFilters(
        string $field = 'shipping_method',
        $value = null,
        string $condition = 'like'
    ): array {
        if ($value === null) {
            $value = $this->getCarrierCode() . '_%';
        }

        return [
            $this->filterBuilder
                ->setField($field)
                ->setConditionType($condition)
                ->setValue($value)
                ->create(),
        ];
    }

    /**
     * @param \Magento\Sales\Model\Order $order
     * @return string
     */
    public function getUniqueOrderId(\Magento\Sales\Model\Order $order)
    {
        return $order->getIncrementId();
    }

    /**
     * @param \Magento\Quote\Model\Quote|\Magento\Sales\Model\Order $entity
     * @return array
     */
    public function extractPickupPoint($entity): array
    {
        $address = $entity->getShippingAddress();
        if (!$address) {
            return [];
        }

        $point = explode('_', $address->getPickupPoint());
        if (count($point) < 2) {
            return [];
        }

        $result = [
            'carrier' => array_shift($point),
        ];
        $result['pickup'] = implode('_', $point);

        return $result;
    }

    /**
     * @return string
     */
    protected function getDebugConfigPath(): string
    {
        return 'debug';
    }
}
