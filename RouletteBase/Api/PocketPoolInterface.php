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
 * Pool class to hold all possible Pockets
 */
interface PocketPoolInterface
{
    /**
     * Load All available Pockets
     * Could be limited by maximum Fan Level
     *
     * @param int $funLimit Limits is for the weak in spirit
     * @return \Mozok\RouletteBase\Api\PocketInterface[]
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function loadPockets(int $funLimit = \Mozok\RouletteBase\Api\FunLevelInterface::EXTREME): array;
}
