<?php

namespace rollun\amazonItemSearch\Client\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use ApaiIO\Operations\Search;

/**
 * Class AmazonSearchOperationFactory
 *
 * <code>
 * 'amazonSearchOperation' => [
 *     'responseGroup' => [ // strongly not recommended to change
 *         'SalesRank',
 *         'OfferFull',
 *         'Large',
 *     ],
 *     'minimum_price' => 0, // not necessary; a value in the bank view (10000 == $100.00)
 *     'maximum_price' => 10000, // not necessary; a value in the bank view (10000 == $100.00)
 * ],
 * </code>
 *
 * @package rollun\amazonItemSearch\Client\Factory
 */
class AmazonSearchOperationFactory implements FactoryInterface
{
    const AMAZON_SEARCH_OPERATION_KEY = 'amazonSearchOperation';

    const RESPONSE_GROUP_KEY = 'responseGroup';

    const MINIMUM_PRICE_KEY = 'minimumPrice';

    const MAXIMUM_PRICE_KEY = 'maximumPrice';

    /**
     * {@inheritdoc}
     *
     * {@inheritdoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('config');
        $instance = new Search();
        // If there is no config for the service we will use it with parameters by default
        if (!isset($config[static::AMAZON_SEARCH_OPERATION_KEY])) {
            return $instance;
        }
        // Otherwise check the parameters and set them if they exist
        $serviceConfig = $config[static::AMAZON_SEARCH_OPERATION_KEY];
        if (isset($serviceConfig[static::RESPONSE_GROUP_KEY])) {
            $instance->setResponseGroup($serviceConfig[static::RESPONSE_GROUP_KEY]);
        }
        if (isset($serviceConfig[static::MINIMUM_PRICE_KEY])) {
            $instance->setMinimumPrice($serviceConfig[static::MINIMUM_PRICE_KEY]);
        }
        if (isset($serviceConfig[static::MAXIMUM_PRICE_KEY])) {
            $instance->setMaximumPrice($serviceConfig[static::MAXIMUM_PRICE_KEY]);
        }
        return $instance;
    }
}