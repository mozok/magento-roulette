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

use Mozok\RouletteExternalRequest\Service\GetRandomWeather;

/**
 * Pocket with random City Weather
 */
class RandomWeather implements \Mozok\RouletteBase\Api\PocketInterface
{
    /**
     * @var GetRandomWeather
     */
    private $getRandomWeather;

    /**
     * @param GetRandomWeather $getRandomWeather
     */
    public function __construct(
        GetRandomWeather $getRandomWeather
    ) {
        $this->getRandomWeather = $getRandomWeather;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'Random Weather';
    }

    /**
     * @inheritdoc
     */
    public function getDescription(): string
    {
        return 'Load Current Weather for random City';
    }

    /**
     * @inheritdoc
     */
    public function process()
    {
        $weather = $this->getRandomWeather->execute();
        return sprintf(
            'Weather in %s (%s): %s°C and %s',
            $weather->getCity(),
            $weather->getCountry(),
            $weather->getTemperature(),
            $weather->getWeatherInfo()
        );
    }
}
