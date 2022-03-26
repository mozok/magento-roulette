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

namespace Mozok\RouletteExternalRequest\Service;

use Mozok\RouletteExternalRequest\Model\Data\Weather;
use Mozok\RouletteExternalRequest\Model\Data\WeatherFactory;
use Mozok\RouletteExternalRequest\Service\DoApiRequest;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Get random city from geodb-free-service.wirefreethought.com and weather for it from api.open-meteo.com
 */
class GetRandomWeather
{
    const CITY_API_REQUEST_URL = 'http://geodb-free-service.wirefreethought.com/v1/geo/cities/';
    const WEATHER_API_REQUEST_URL = 'https://api.open-meteo.com/v1/forecast/';

    /**
     * @var DoApiRequest
     */
    private $doApiRequest;

    /**
     * @var WeatherFactory
     */
    private $weatherFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @param DoApiRequest $doApiRequest
     * @param WeatherFactory $weatherFactory
     * @param SerializerInterface $serializer
     */
    public function __construct(
        DoApiRequest $doApiRequest,
        WeatherFactory $weatherFactory,
        SerializerInterface $serializer
    ) {
        $this->doApiRequest = $doApiRequest;
        $this->weatherFactory = $weatherFactory;
        $this->serializer = $serializer;
    }

    /**
     * @return Weather
     */
    public function execute(): Weather
    {
        $weather = $this->weatherFactory->create();
        $this->processCity($weather);
        $this->processWeatherForCity($weather);

        return $weather;
    }

    /**
     * @param Weather $weather
     * @return void
     */
    private function processCity(Weather $weather)
    {
        $randomPage = $this->getRandomCityPage();
        $params = [
            \GuzzleHttp\RequestOptions::QUERY => [
                'limit' => 1,
                'offset' => $randomPage,
                'hateoasMode' => 'off',
            ]
        ];
        $responseContent = $this->doRequest(self::CITY_API_REQUEST_URL, $params);
        $cityData = array_shift($responseContent['data']);
        $weather->setCity($cityData[Weather::CITY]);
        $weather->setCountry($cityData[Weather::COUNTRY]);
        $weather->setLatitude($cityData[Weather::LATITUDE]);
        $weather->setLongitude($cityData[Weather::LONGITUDE]);
    }

    /**
     * @return int|null
     */
    private function getRandomCityPage(): ?int
    {
        $params = [
            \GuzzleHttp\RequestOptions::QUERY => [
                'limit' => 1,
                'offset' => 0,
                'hateoasMode' => 'off',
            ]
        ];

        $responseContent = $this->doRequest(self::CITY_API_REQUEST_URL, $params);

        $totalPages = 1000;
        if (is_array($responseContent)
            && array_key_exists('metadata', $responseContent)
            && array_key_exists('totalCount', $responseContent['metadata'])
        ) {
            $totalPages = $responseContent['metadata']['totalCount'];
        }
        return rand(1, $totalPages - 1);
    }

    /**
     * @param Weather $weather
     * @return void
     */
    private function processWeatherForCity(Weather $weather)
    {
        $params = [
            \GuzzleHttp\RequestOptions::QUERY => [
                'latitude' => $weather->getLatitude(),
                'longitude' => $weather->getLongitude(),
                'current_weather' => true
            ]
        ];
        $responseContent = $this->doRequest(self::WEATHER_API_REQUEST_URL, $params);
        $weatherData = $responseContent['current_weather'];
        $weather->setTemperature($weatherData[Weather::TEMPERATURE]);
        $weather->setWeatherCode($weatherData[Weather::WEATHER_CODE]);
        $weather->setWindSpeed($weatherData[Weather::WIND_SPEED]);
    }

    /**
     * @param string $url
     * @param array $params
     * @return array|bool|float|int|string|null
     */
    private function doRequest(string $url, array $params = [])
    {
        $response = $this->doApiRequest->execute($url, $params);
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents();
        $responseContent = $this->serializer->unserialize($responseContent);
        return $responseContent;
    }
}
