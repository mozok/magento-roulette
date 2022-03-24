<?php
/**
 * Copyright 2022 Evgen Mozok
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Mozok\RouletteProduct\Model\Pocket;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

/**
 * Roulette Pocket to find Lucky Random Product
 * @todo: fix code style
 */
class LuckyProduct implements \Mozok\RouletteBase\Api\PocketInterface
{
    /**
     * Product collection factory
     *
     * @var CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @param CollectionFactory $productCollectionFactory
     */
    public function __construct(
        CollectionFactory $productCollectionFactory
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'Lucky Product';
    }

    /**
     * @inheritdoc
     */
    public function getDescription(): string
    {
        return 'Try and Get your Lucky Product';
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        $product = $this->getRandomProduct();

        return sprintf('Your Lucky Product "%s" (SKU:%s)', $product->getName(), $product->getSku());
    }

    /**
     * @return \Magento\Catalog\Model\Product
     */
    private function getRandomProduct()
    {
        /** @var \Magento\Catalog\Model\ResourceModel\Product\Collection<ProductInterface> $collection */
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToSelect(ProductInterface::NAME);
        $collection->getSelect()->order('rand()');
        $collection->setPage(1, 1);

        return $collection->getFirstItem();
    }
}
