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

namespace Mozok\RouletteExternalRequest\Model\Data;

use Magento\Framework\DataObject;

/**
 * Whether DataModel
 */
class Weather extends DataObject
{
    /**
     * DataModel fields
     */
    const CITY = 'city';
    const COUNTRY = 'country';
    const LATITUDE = 'latitude';
    const LONGITUDE = 'longitude';
    const TEMPERATURE = 'temperature';
    const WEATHER_CODE = 'weathercode';
    const WIND_SPEED = 'windspeed';

    /**
     * WMO Weather interpretation codes
     * @var string[]
     */
    private $wmoCodes = [
        0 => 'Clear sky',
        1 => 'Mainly clear',
        2 => 'Partly cloudy',
        3 => 'Overcast',
        45 => 'Fog',
        48 => 'Depositing rime fog',
        51 => 'Drizzle: Light',
        53 => 'Drizzle: Moderate',
        55 => 'Drizzle: Dense intensity',
        56 => 'Freezing Drizzle: Light',
        57 => 'Freezing Drizzle: Dense intensity',
        61 => 'Rain: Slight',
        63 => 'Rain: Moderate',
        65 => 'Rain: Heavy intensity',
        66 => 'Freezing Rain: Light',
        67 => 'Freezing Rain: Heavy intensity',
        71 => 'Snow fall: Slight',
        73 => 'Snow fall: Moderate',
        75 => 'Snow fall: Heavy intensity',
        77 => 'Snow grains',
        80 => 'Rain showers: Slight',
        81 => 'Rain showers: Moderate',
        82 => 'Rain showers: Violent',
        85 => 'Snow showers: Slight',
        86 => 'Snow showers: Heavy',
        95 => 'Thunderstorm: Slight or moderate',
        96 => 'Thunderstorm with slight hail',
        99 => 'Thunderstorm with heavy hail'
    ];

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->_getData(self::CITY);
    }

    /**
     * @param string|null $city
     * @return Weather
     */
    public function setCity(?string $city): Weather
    {
        return $this->setData(self::CITY, $city);
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->_getData(self::COUNTRY);
    }

    /**
     * @param string|null $country
     * @return Weather
     */
    public function setCountry(?string $country): Weather
    {
        return $this->setData(self::COUNTRY, $country);
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->_getData(self::LATITUDE);
    }

    /**
     * @param float|null $latitude
     * @return Weather
     */
    public function setLatitude(?float $latitude): Weather
    {
        return $this->setData(self::LATITUDE, $latitude);
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->_getData(self::LONGITUDE);
    }

    /**
     * @param float|null $longitude
     * @return Weather
     */
    public function setLongitude(?float $longitude): Weather
    {
        return $this->setData(self::LONGITUDE, $longitude);
    }

    /**
     * @return float|null
     */
    public function getTemperature(): ?float
    {
        return $this->_getData(self::TEMPERATURE);
    }

    /**
     * @param float|null $temperature
     * @return Weather
     */
    public function setTemperature(?float $temperature): Weather
    {
        return $this->setData(self::TEMPERATURE, $temperature);
    }

    /**
     * @return string|null
     */
    public function getWeatherCode(): ?string
    {
        return $this->_getData(self::WEATHER_CODE);
    }

    /**
     * @param string|null $weatherCode
     * @return Weather
     */
    public function setWeatherCode(?string $weatherCode): Weather
    {
        return $this->setData(self::WEATHER_CODE, $weatherCode);
    }

    /**
     * @return float|null
     */
    public function getWindSpeed(): ?float
    {
        return $this->_getData(self::WIND_SPEED);
    }

    /**
     * @param float|null $windSpeed
     * @return Weather
     */
    public function setWindSpeed(?float $windSpeed): Weather
    {
        return $this->setData(self::WIND_SPEED, $windSpeed);
    }

    /**
     * @return string|null
     */
    public function getWeatherInfo(): ?string
    {
        $wmoCode = $this->_getData(self::WEATHER_CODE);
        if (isset($this->wmoCodes[$wmoCode])) {
            return $this->wmoCodes[$wmoCode];
        }
        return null;
    }
}
