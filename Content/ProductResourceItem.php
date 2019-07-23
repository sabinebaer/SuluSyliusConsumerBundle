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

use Sulu\Bundle\SyliusConsumerBundle\Model\Product\Product;
use Sulu\Bundle\SyliusConsumerBundle\Model\Product\ProductView;
use Sulu\Component\SmartContent\ResourceItemInterface;

class ProductResourceItem extends ProductView implements ResourceItemInterface
{
    /**
     * @var Product
     */
    private $product;

    public function setResource($product) {
        $this->product = $product;
    }

    public function getResource()
    {
        return $this->product;
    }
}
