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

namespace Mozok\RouletteBase\Api;

/**
 * Manage actions with Roulette
 */
interface RouletteManagerInterface
{
    /**
     * Spin the roulette to get a random result
     * @return string|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function spin();

    /**
     * Read information about all pockets
     * @return \Generator<\Mozok\RouletteBase\Api\PocketInterface>
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function read(): \Generator;
}
