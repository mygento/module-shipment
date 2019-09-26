<?php

/**
 * @author Mygento Team
 * @copyright 2016-2019 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Helper;

class Dimensions
{
    /**
     * @var \Mygento\Base\Helper\Data
     */
    private $helper;

    /**
     * @param \Mygento\Base\Helper\Data $helper
     */
    public function __construct(
        \Mygento\Base\Helper\Data $helper
    ) {
        $this->helper = $helper;
    }

    /**
     * Get items sizes
     * @param mixed $sizeCoefficient
     * @param mixed $weightCoefficient
     * @param mixed $object
     * @param mixed $prefix
     * @return array
     */
    public function getItemsSizes($sizeCoefficient, $weightCoefficient, $object, $prefix = '')
    {
        $resultArray = [];

        if (!$object->getAllItems()) {
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

                $itemArray = [];

                $itemArray['length'] = $this->helper->getAttrValueByParam(
                    $prefix . 'length',
                    $productId
                );
                $itemArray['length'] = $this->helper->formatToNumber($itemArray['length']);
                $itemArray['length'] = round($itemArray['length'] * $sizeCoefficient, 2);

                $itemArray['height'] = $this->helper->getAttrValueByParam(
                    $prefix . 'height',
                    $productId
                );
                $itemArray['height'] = $this->helper->formatToNumber($itemArray['height']);
                $itemArray['height'] = round($itemArray['height'] * $sizeCoefficient, 2);

                $itemArray['width'] = $this->helper->getAttrValueByParam(
                    $prefix . 'width',
                    $productId
                );
                $itemArray['width'] = $this->helper->formatToNumber($itemArray['width']);
                $itemArray['width'] = round($itemArray['width'] * $sizeCoefficient, 2);

                $itemArray['volume'] = $itemArray['length']
                    * $itemArray['height']
                    * $itemArray['width'];
                $itemArray['weight'] = round($item->getWeight() * $weightCoefficient, 2);

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
}
