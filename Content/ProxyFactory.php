<?php

declare(strict_types=1);

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Content;

use JMS\Serializer\SerializerInterface;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use ProxyManager\Proxy\LazyLoadingInterface;

class ProxyFactory
{
    /**
     * @var LazyLoadingValueHolderFactory
     */
    private $proxyFactory;

    public function __construct(LazyLoadingValueHolderFactory $proxyFactory)
    {
        $this->proxyFactory = $proxyFactory;
    }

    public function createProxy(SerializerInterface $serializer, $data)
    {
        return $this->proxyFactory->createProxy(
            \ArrayObject::class,
            function (
                &$wrappedObject,
                LazyLoadingInterface $proxy,
                $method,
                array $parameters,
                &$initializer
            ) use ($serializer, $data) {
                $initializer = null;
                /** @var array $serializedData */
                $serializedData = $serializer->serialize($data, 'array');
                $wrappedObject = new \ArrayObject($serializedData);

                return true;
            }
        );
    }
}
