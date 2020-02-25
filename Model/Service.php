<?php

/**
 * @author Mygento Team
 * @copyright 2016-2020 Mygento (https://www.mygento.ru)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Model;

use Magento\Sales\Api\Data\OrderInterface;

class Service implements \Mygento\Shipment\Api\Service\BaseInterface
{
    /**
     * @var \Mygento\Shipment\Api\PointManagerInterface
     */
    private $pointManager;

    /**
     * @var \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory
     */
    private $resultFactory;

    /**
     * @var \Mygento\Base\Helper\Discount
     */
    private $taxHelper;

    /**
     * @param \Mygento\Shipment\Api\PointManagerInterface $pointManager
     * @param \Mygento\Base\Helper\Discount $taxHelper
     * @param \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory $resultFactory
     */
    public function __construct(
        \Mygento\Shipment\Api\PointManagerInterface $pointManager,
        \Mygento\Base\Helper\Discount $taxHelper,
        \Mygento\Shipment\Api\Data\CalculateResultInterfaceFactory $resultFactory
    ) {
        $this->pointManager = $pointManager;
        $this->taxHelper = $taxHelper;
        $this->resultFactory = $resultFactory;
    }

    /**
     * @return \Mygento\Shipment\Api\Data\CalculateResultInterface
     */
    public function getCalculateResultInstance()
    {
        return $this->resultFactory->create();
    }

    /**
     * @return \Mygento\Shipment\Api\PointManagerInterface
     */
    public function getPointManager()
    {
        return $this->pointManager;
    }

    /**
     * @param string $code
     * @param int $estimate
     * @return string
     */
    public function convertEstimateToDate(string $code, int $estimate = 0): string
    {
        return date('Y-m-d', strtotime('+' . $estimate . ' day'));
    }

    /**
     * @return \Mygento\Base\Helper\Discount
     */
    public function getTaxHelper()
    {
        return $this->taxHelper;
    }

    /**
     * @param \Magento\Sales\Api\Data\OrderInterface $order
     * @param \Mygento\Shipment\Helper\Data $helper
     * @return array
     */
    public function getTaxInfoForItems(
        OrderInterface $order,
        \Mygento\Shipment\Helper\Data $helper
    ) {
        return $this->taxHelper->getRecalculated(
            $order,
            $helper->getConfig('tax_options/tax_products'),
            $helper->getConfig('tax_product_attr'),
            $helper->getConfig('tax_options/tax_shipping')
        );
    }
}
