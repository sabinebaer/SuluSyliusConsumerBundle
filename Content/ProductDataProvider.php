<?php

/*
 * This file is part of Sulu.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Sulu\Bundle\SyliusConsumerBundle\Content;

use Sulu\Bundle\CategoryBundle\Category\CategoryManager;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Query\ListProductViewsQuery;
use Sulu\Component\SmartContent\Configuration\Builder;
use Sulu\Component\SmartContent\DataProviderInterface;
use Sulu\Component\SmartContent\DataProviderResult;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductDataProvider implements DataProviderInterface
{
    private $messageBus;

    private $categoryManager;

    public function __construct(MessageBusInterface $messageBus, CategoryManager $categoryManager)
    {
        $this->messageBus = $messageBus;
        $this->categoryManager = $categoryManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration()
    {
        return Builder::create()
            ->enableCategories()
            ->getConfiguration();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultPropertyParameter()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function resolveDataItems(array $filters, array $propertyParameter, array $options = [], $limit = null, $page = 1, $pageSize = null)
    {
        $productViews = $this->findProductsByFilters($options['locale'], $filters['categories']);

        $results = [];
        foreach ($productViews as $productView) {
            $results[] = new ProductDataItem($productView);
        }

        return new DataProviderResult($results, false);
    }

    /**
     * {@inheritdoc}
     */
    public function resolveResourceItems(array $filters, array $propertyParameter, array $options = [], $limit = null, $page = 1, $pageSize = null)
    {
        $productViews = $this->findProductsByFilters($options['locale'], $filters['categories']);

        return new DataProviderResult($productViews, false);
    }

    /**
     * {@inheritdoc}
     */
    public function resolveDatasource($datasource, array $propertyParameter, array $options)
    {
        return;
    }

    private function findProductsByFilters(string $locale, array $categories)
    {
        $categories = $this->categoryManager->findByIds($categories);
        $categoryKeys = [];
        foreach ($categories as $category) {
            $categoryKeys[] = $category->getKey();
        }

        $query = new ListProductViewsQuery($locale, null, null, null, [], $categoryKeys);
        $this->messageBus->dispatch($query);

        return $query->getProductViewList()->getProductViews();
    }
}
