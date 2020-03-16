<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Api\Service;

interface BaseInterface
{
    /**
     * @return \Mygento\Shipment\Api\Data\CalculateResultInterface
     */
    public function getCalculateResultInstance();

    /**
     * @param string $from
     * @param string $to
     * @return \Mygento\Shipment\Api\Data\EstimateTimeInterface
     */
    public function getEstimateTimeInstance(string $from, string $to);

    /**
     * @return \Mygento\Shipment\Api\PointManagerInterface
     */
    public function getPointManager();

    /**
     * @return \Mygento\Base\Helper\Discount
     */
    public function getTaxHelper();

    /**
     * @return \Mygento\Shipment\Helper\Dimensions
     */
    public function getDimensionHelper();

    /**
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @param \Mygento\Shipment\Helper\Data $helper
     */
    public function getTaxInfoForItems(
        \Magento\Sales\Api\Data\OrderInterface $order,
        \Mygento\Shipment\Helper\Data $helper
    );

    /**
     * @param string $code
     * @param int $estimate
     * @return string
     */
    public function convertEstimateToDate(string $code, int $estimate): string;
}
