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

use Magento\Framework\Event\ManagerInterface;
use Mozok\RouletteBase\Api\PocketPoolInterface;
use Mozok\RouletteBase\Api\RouletteManagerInterface;

/**
 * Base Roulette Manager implementation
 */
class RouletteManager implements RouletteManagerInterface
{
    const EVENT_ROULETTE_PROCESS_BEFORE = 'roulette_process_before';
    const EVENT_ROULETTE_PROCESS_AFTER = 'roulette_process_after';

    /**
     * @var PocketPoolInterface
     */
    private $pool;

    /**
     * @var ManagerInterface
     */
    protected $eventManager;

    /**
     * @param PocketPoolInterface $pool
     * @param ManagerInterface $eventManager
     */
    public function __construct(
        PocketPoolInterface $pool,
        ManagerInterface $eventManager
    ) {
        $this->pool = $pool;
        $this->eventManager = $eventManager;
    }

    /**
     * @inheritdoc
     */
    public function spin(int $funLimit = \Mozok\RouletteBase\Api\FunLevelInterface::EXTREME)
    {
        $pockets = $this->pool->loadPockets($funLimit);
        $pocket = $pockets[array_rand($pockets)];

        $this->eventManager->dispatch(self::EVENT_ROULETTE_PROCESS_BEFORE, ['pocket' => $pocket]);
        $result = $pocket->process();
        $this->eventManager->dispatch(
            self::EVENT_ROULETTE_PROCESS_AFTER,
            ['pocket' => $pocket, 'result' => $result]
        );

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function read(): \Generator
    {
        foreach ($this->pool->loadPockets() as $pocket) {
            yield $pocket;
        }
    }
}
