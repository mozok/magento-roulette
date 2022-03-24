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
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\State;
use Magento\Framework\Registry;

/**
 * Roulette Pocket to find out what Product has a Bad Luck
 * @todo: fix code style
 */
class BadLackProduct implements \Mozok\RouletteBase\Api\PocketInterface
{

    /**
     * Product collection factory
     *
     * @var CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var State
     */
    private $state;

    /**
     * The application registry.
     *
     * @var Registry
     */
    private $registry;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @param CollectionFactory $productCollectionFactory
     * @param State $state
     * @param Registry $registry
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        CollectionFactory $productCollectionFactory,
        State $state,
        Registry $registry,
        ProductRepositoryInterface $productRepository
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->state = $state;
        $this->registry = $registry;
        $this->productRepository = $productRepository;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'Bad Luck Product';
    }

    /**
     * @inheritdoc
     */
    public function getDescription(): string
    {
        return 'Find Product with Bad Luck and Get Rid of it';
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        $product = $this->getRandomProduct();

        $this->getRidOfProduct($product->getSku());

        return sprintf('Product SKU %s has a Bad Lack', $product->getSku());
    }

    /**
     * Get Rid of Bad Luck Product
     * @param string $sku
     * @return void
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    private function getRidOfProduct(string $sku)
    {
        if (!$this->registry->registry('isSecureArea')) {
            $this->registry->register('isSecureArea', true);
        }

        try {
            $this->state->getAreaCode();
        } catch (\Magento\Framework\Exception\LocalizedException $exception) {
            $this->state->setAreaCode(\Magento\Framework\App\Area::AREA_ADMINHTML);
        }

        $this->productRepository->deleteById($sku);
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
