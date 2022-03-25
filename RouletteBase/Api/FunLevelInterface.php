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
 * Lists Level of Fun for Roulette Pockets
 */
interface FunLevelInterface
{
    /**
     * Maybe it is not even Fun
     */
    public const DEFAULT = 0;

    /**
     * Casual Pocket, nothing special
     */
    public const CASUAL = 1;

    /**
     * Some advanced Fun
     */
    public const ADVANCED = 2;

    /**
     * So Fun, that even hurt
     */
    public const EXTREME = 3;
}
