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

namespace Mozok\RouletteBackend\Model\Pocket;

use Magento\Framework\App\Cache\Manager;
use Magento\Framework\Event\ManagerInterface;

/**
 * Nothing special, just clean cache
 */
class CleanCache implements \Mozok\RouletteBase\Api\PocketInterface
{
    /**
     * @var ManagerInterface
     */
    protected $eventManager;

    /**
     * @var Manager
     */
    protected $cacheManager;

    /**
     * @param ManagerInterface $eventManager
     * @param Manager $cacheManager
     */
    public function __construct(
        ManagerInterface $eventManager,
        Manager $cacheManager
    ) {
        $this->eventManager = $eventManager;
        $this->cacheManager = $cacheManager;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'Cache Clean';
    }

    /**
     * @inheritdoc
     */
    public function getDescription(): string
    {
        return 'It cleans the cache';
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        $this->eventManager->dispatch('adminhtml_cache_flush_system');

        $cacheTypes = $this->cacheManager->getAvailableTypes();
        $this->cacheManager->clean($cacheTypes);

        return 'You seems to be busy, so we cleaned the cache for you :)';
    }
}
