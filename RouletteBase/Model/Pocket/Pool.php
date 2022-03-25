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

namespace Mozok\RouletteBase\Model\Pocket;

use Magento\Framework\Exception\LocalizedException;
use Mozok\RouletteBase\Api\PocketPoolInterface;
use Mozok\RouletteBase\Model\PocketFactory;

class Pool implements PocketPoolInterface
{
    /**
     * @var PocketFactory
     */
    private $pocketFactory;

    /**
     * @var mixed[]
     */
    private $pockets = [];

    /**
     * @var \Mozok\RouletteBase\Api\PocketInterface[]
     */
    private $pocketInstances = [];

    /**
     * @param PocketFactory $pocketFactory
     * @param mixed[] $pockets
     */
    public function __construct(
        PocketFactory $pocketFactory,
        array $pockets = []
    ) {
        $this->pocketFactory = $pocketFactory;
        $this->pockets = $pockets;
    }

    /**
     * {@inheritDoc}
     */
    public function loadPockets(int $funLimit = \Mozok\RouletteBase\Api\FunLevelInterface::EXTREME): array
    {
        if ($this->pocketInstances) {
            return $this->pocketInstances;
        }

        foreach ($this->pockets as $name => $pocket) {
            if (empty($pocket['class'])) {
                throw new LocalizedException(__('The parameter "class" is missing. Set the "class" and try again.'));
            }

            if (empty($pocket['funLevel'])) {
                $pocket['funLevel'] = \Mozok\RouletteBase\Api\FunLevelInterface::DEFAULT;
            }

            if ($pocket['funLevel'] > $funLimit) {
                continue;
            }

            $this->pocketInstances[$name] = $this->pocketFactory->create($pocket['class']);
        }

        return $this->pocketInstances;
    }
}
