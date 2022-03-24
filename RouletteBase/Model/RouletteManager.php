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

namespace Mozok\RouletteBase\Model;

use Mozok\RouletteBase\Api\PocketPoolInterface;
use Mozok\RouletteBase\Api\RouletteManagerInterface;

/**
 * Base Roulette Manager implementation
 */
class RouletteManager implements RouletteManagerInterface
{
    /**
     * @var PocketPoolInterface
     */
    private $pool;

    /**
     * @param PocketPoolInterface $pool
     */
    public function __construct(
        PocketPoolInterface $pool
    ) {
        $this->pool = $pool;
    }

    /**
     * @inheritdoc
     */
    public function spin()
    {
        $pockets = $this->pool->getPockets();
        $pocket = $pockets[array_rand($pockets)];
        return $pocket->process();
    }

    /**
     * @inheritdoc
     */
    public function read(): \Generator
    {
        foreach ($this->pool->getPockets() as $pocket) {
            yield $pocket;
        }
    }
}
