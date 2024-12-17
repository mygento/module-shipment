<?php

/**
 * @author Mygento Team
 * @copyright 2016-2024 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Helper;

use Magento\Framework\Api\Filter;
use Mygento\Base\Api\ProductAttributeHelperInterface;

class Data extends \Mygento\Base\Helper\Data
{
    private const XML_TEST = 'test';
    private const XML_TITLE = 'title';
    private const XML_TAX_ENABLED = 'tax_options/tax';
    private const XML_TAX_SAME_PRODUCT = 'tax_options/tax_same';
    private const XML_TAX_ALL_PRODUCT = 'tax_options/tax_products';
    private const XML_TAX_PRODUCT_ATTR = 'tax_options/tax_product_attr';
    private const XML_TAX_SHIPPING = 'tax_options/tax_shipping';
    private const XML_AUTO_SHIPPING = 'order_statuses/autoshipping';
    private const XML_AUTO_SHIPPING_STATUSES = 'order_statuses/autoshipping_statuses';
    private const XML_SHIPMENT_SUCCESS_STATUS = 'order_statuses/shipment_success_status';
    private const XML_SHIPMENT_FAIL_STATUS = 'order_statuses/shipment_fail_status';
    private const XML_SHIPMENT_TRACK_CHECK = 'order_statuses/track_check';
    private const XML_SHIPMENT_TRACK_STATUSES = 'order_statuses/track_statuses';
    private const XML_SHIPMENT_TRACK_MAPPING = 'order_statuses/track_mapping';
    private const XML_MARKING = 'marking/enabled';
    private const XML_MARKING_FLAG = 'marking/marking_flag';
    private const XML_MARKING_FIELD = 'marking/marking_field';
    private const XML_MARKING_REFUND = 'marking/marking_refund';

    /** @var \Magento\Checkout\Model\Session */
    protected $checkoutSession;

    /** @var string */
    protected $code = 'shipment';

    /** @var \Magento\Framework\Api\FilterBuilder */
    private $filterBuilder;

    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Mygento\Base\Model\LogManager $logManager,
        \Magento\Framework\Encryption\Encryptor $encryptor,
        \Magento\Framework\App\Helper\Context $context,
    ) {
        parent::__construct(
            $logManager,
            $encryptor,
            $context,
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
        if ($order->getIsVirtual()) {
            return false;
        }

        return strpos($order->getShippingMethod(), $this->getCode() . '_') !== false;
    }

    public function getCarrierCode(): string
    {
        return $this->getCode();
    }

    public function getCarrierTitle($scopeCode = null): string
    {
        return $this->getConfig(self::XML_TITLE, $scopeCode);
    }

    /**
     * @param mixed|null $scopeCode
     */
    public function isTestMode($scopeCode = null): bool
    {
        return (bool) $this->getConfig(self::XML_TEST, $scopeCode);
    }

    /**
     * @param mixed|null $scopeCode
     */
    public function isEnabledTax($scopeCode = null): bool
    {
        return (bool) $this->getConfig(self::XML_TAX_ENABLED, $scopeCode);
    }

    /**
     * @param mixed|null $scopeCode
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
     */
    public function isEnabledAutoShipping($scopeCode = null): bool
    {
        return (bool) $this->getConfig(self::XML_AUTO_SHIPPING, $scopeCode);
    }

    /**
     * @param mixed|null $scopeCode
     */
    public function isEnabledTrackCheck($scopeCode = null): bool
    {
        return (bool) $this->getConfig(self::XML_SHIPMENT_TRACK_CHECK, $scopeCode);
    }

    /**
     * @param mixed|null $scopeCode
     */
    public function getAutoShippingStatuses($scopeCode = null): array
    {
        return array_filter(explode(
            ',',
            $this->getConfig(self::XML_AUTO_SHIPPING_STATUSES, $scopeCode) ?: '',
        ));
    }

    /**
     * @param mixed|null $scopeCode
     */
    public function getTrackCheckStatuses($scopeCode = null): array
    {
        return array_filter(explode(
            ',',
            $this->getConfig(self::XML_SHIPMENT_TRACK_STATUSES, $scopeCode) ?: '',
        ));
    }

    /**
     * @param mixed|null $scopeCode
     */
    public function getTrackMapping($scopeCode = null): string
    {
        return $this->getConfig(self::XML_SHIPMENT_TRACK_MAPPING, $scopeCode) ?: '[]';
    }

    /**
     * @param int|string $scopeCode
     */
    public function getShipmentFailStatus($scopeCode = null)
    {
        return $this->getConfig(self::XML_SHIPMENT_FAIL_STATUS, $scopeCode) ?: false;
    }

    /**
     * @param int|string $scopeCode
     */
    public function getShipmentSuccessStatus($scopeCode = null)
    {
        return $this->getConfig(self::XML_SHIPMENT_SUCCESS_STATUS, $scopeCode) ?: false;
    }

    /**
     * @param mixed|null $scopeCode
     */
    public function isEnabledMarking($scopeCode = null): bool
    {
        return (bool) $this->getConfig(self::XML_MARKING, $scopeCode);
    }

    /**
     * @param int|string $scopeCode
     */
    public function getMarkingFlag($scopeCode = null)
    {
        return $this->getConfig(self::XML_MARKING_FLAG, $scopeCode);
    }

    /**
     * @param int|string $scopeCode
     */
    public function getMarking($scopeCode = null)
    {
        return $this->getConfig(self::XML_MARKING_FIELD, $scopeCode);
    }

    /**
     * @param int|string $scopeCode
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
        string $condition = 'like',
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

    public function getUniqueOrderId(\Magento\Sales\Model\Order $order)
    {
        return $order->getIncrementId();
    }

    /**
     * @param \Magento\Quote\Model\Quote|\Magento\Sales\Model\Order $entity
     */
    public function extractPickupPoint($entity): array
    {
        $address = $entity->getShippingAddress();
        if (!$address) {
            return [];
        }

        $point = explode('_', $address->getPickupPoint() ?? '');
        if (count($point) < 2) {
            return [];
        }

        $result = [
            'carrier' => array_shift($point),
        ];
        $result['pickup'] = implode('_', $point);

        return $result;
    }

    protected function getDebugConfigPath(): string
    {
        return 'debug';
    }
}
