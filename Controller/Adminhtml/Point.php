<?php

/**
 * @author Mygento Team
 * @copyright 2016-2025 Mygento (https://www.mygento.com)
 * @package Mygento_Shipment
 */

namespace Mygento\Shipment\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Mygento\Shipment\Api\PointRepositoryInterface;

abstract class Point extends Action
{
    /**
     * Authorization level
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Mygento_Shipment::point';

    public function __construct(
        protected PointRepositoryInterface $repository,
        protected Registry $coreRegistry,
        Action\Context $context,
    ) {
        parent::__construct($context);
    }
}
