# Magento 2 Shipment Base

[![Build Status](https://travis-ci.org/mygento/module-shipment.svg?branch=v2.3)](https://travis-ci.org/mygento/module-shipment)
[![Latest Stable Version](https://poser.pugx.org/mygento/module-shipment/v/stable)](https://packagist.org/packages/mygento/module-shipment)
[![Total Downloads](https://poser.pugx.org/mygento/module-shipment/downloads)](https://packagist.org/packages/mygento/module-shipment)

## Installation with composer
* Include the repository: `composer require mygento/module-shipment`

## Usage

Every extension should have three classes:

- Client inherits \Mygento\Shipment\Model\AbstractClient

  Class is used for communication with API. Exchanges with others through Service.

- Carrier inherits \Mygento\Shipment\Model\AbstractCarrier

  Class is used to work with Magento Shipping Rates

- Service inherits \Mygento\Shipment\Model\AbstractService

  Class is responsible for working with Magento and DB

## Compability

The module is tested on magento version 2.4.x
