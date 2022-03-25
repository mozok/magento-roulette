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

namespace Mozok\RouletteExternalRequest\Model\Pocket;

/**
 * Pocket with random Chuck Norris fact
 */
class ChuckRequest implements \Mozok\RouletteBase\Api\PocketInterface
{
    /**
     * @var \Mozok\RouletteExternalRequest\Service\ChuckRequest
     */
    private $chuckRequest;

    /**
     * @param \Mozok\RouletteExternalRequest\Service\ChuckRequest $chuckRequest
     */
    public function __construct(
        \Mozok\RouletteExternalRequest\Service\ChuckRequest $chuckRequest
    ) {
        $this->chuckRequest = $chuckRequest;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return "Chuck Norris facts";
    }

    /**
     * @inheritdoc
     */
    public function getDescription(): string
    {
        return "Get Yours Chuck Norris Fact from chucknorris.io";
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        $chuckFact = $this->chuckRequest->execute();

        return "Chuck Norris Fact: " . $chuckFact->getValue();
    }
}
