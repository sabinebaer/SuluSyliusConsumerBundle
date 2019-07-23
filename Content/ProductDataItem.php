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

use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductView;
use Sulu\Component\SmartContent\ResourceItemInterface;

class ProductDataItem implements ResourceItemInterface
{
    private $id;

    private $title;

    public function __construct(ProductView $productView)
    {
        $this->id = $productView->getId();
        $this->title = $productView->getProductInformation()->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getResource()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        $this->title;
    }

    /**
     * {@inheritdoc}
     */
    public function getImage()
    {
        return;
    }
}
