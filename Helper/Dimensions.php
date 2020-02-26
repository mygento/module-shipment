<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Helper;

class Dimensions
{
    /**
     * @var \Mygento\Base\Api\ProductAttributeHelperInterface
     */
    private $attrHelper;

    /**
     * @param \Mygento\Base\Api\ProductAttributeHelperInterface $attrHelper
     */
    public function __construct(
        \Mygento\Base\Api\ProductAttributeHelperInterface $attrHelper
    ) {
        $this->attrHelper = $attrHelper;
    }

    /**
     * Get items sizes
     * @param float $sizeCoefficient
     * @param float $weightCoefficient
     * @param mixed $object
     * @param string $prefix
     * @return array
     */
    public function getItemsSizes($sizeCoefficient, $weightCoefficient, $object, $prefix = '')
    {
        $resultArray = [];

        if (empty($object->getAllItems())) {
            return $resultArray;
        }

        foreach ($object->getAllItems() as $item) {
            if (!($item->getProduct() instanceof \Magento\Catalog\Model\Product)
                || $item->getParentItemId()) {
                continue;
            }

            $qty = $item->getQty();
            if ($object instanceof \Magento\Sales\Model\Order) {
                $qty = $item->getQtyOrdered();
            }

            for ($i = 1; $i <= $qty; $i++) {
                $productId = $item->getProductId();

                $itemArray = [
                    'length' => $this->getAttrValueByParam(
                        $prefix . 'length',
                        $productId,
                        $sizeCoefficient
                    ),
                    'height' => $this->getAttrValueByParam(
                        $prefix . 'height',
                        $productId,
                        $sizeCoefficient
                    ),
                    'width' => $this->getAttrValueByParam(
                        $prefix . 'width',
                        $productId,
                        $sizeCoefficient
                    ),
                    'weight' => round($item->getWeight() * $weightCoefficient, 2),
                ];

                $itemArray['volume'] = $itemArray['length']
                    * $itemArray['height']
                    * $itemArray['width'];

                $resultArray[] = $itemArray;
            }
        }

        return $resultArray;
    }

    /**
     * Calculation of total dimensions of all goods
     * @param array $dimensions
     * @return array
     */
    public function dimenAlgo(array $dimensions): array
    {
        $dim = [];
        $result = [
            'width' => 0,
            'height' => 0,
            'length' => 0,
        ];
        foreach ($dimensions as $d) {
            if ($this->isValidDimensionArr($d)) {
                $dim[] = $d;
            }
        }

        foreach ($dim as $d) {
            ($d['width'] > $result['width']) ? $result['width'] = $d['width'] : '';
            ($d['height'] > $result['height']) ? $result['height'] = $d['height'] : '';
            $result['length'] += $d['length'];
        }
        $result['volume'] = $result['length'] * $result['height'] * $result['width'];

        return $result;
    }

    /**
     * Validate dimmensions value
     * @param array $arr
     * @return bool
     */
    public function isValidDimensionArr($arr): bool
    {
        if (!is_array($arr)
            || !array_key_exists('width', $arr)
            || !array_key_exists('height', $arr)
            || !array_key_exists('length', $arr)) {
            return false;
        }

        foreach ($arr as $a) {
            if ((!is_int($a) && !is_float($a))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param type $attributeCode
     * @param type $productId
     * @return type
     */
    public function getProductAttrValue($attributeCode, $productId)
    {
        $attribute = $this->productResource->getAttribute($attributeCode);
        $store = $this->storeManager->getStore();

        $value = $this->productResource->getAttributeRawValue($productId, $attributeCode, $store);
        if (!$attribute->usesSource()) {
            if (!empty($value)) {
                return $value;
            }

            return $value;
        }

        return $attribute->getSource()->getOptionText($value);
    }

    /**
     * Force convert to float
     *
     * @param mixed $value
     * @return float
     */
    public function formatToNumber($value)
    {
        return (float) str_replace(
            [' ', ','],
            ['', '.'],
            $value
        );
    }

    /**
     * @param string $configPath
     * @param int|string $productId
     * @param float $coefficient
     */
    private function getAttrValueByParam($configPath, $productId, $coefficient = 1): float
    {
        $value = $this->attrHelper->getValueByConfigPathOrDefault($configPath, $productId);

        return round($this->formatToNumber($value) * $coefficient, 2);
    }
}
