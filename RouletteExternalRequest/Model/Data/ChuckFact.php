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

class ChuckFact extends DataObject
{
    const ID = 'id';
    const ICON_URL = 'icon_url';
    const URL = 'url';
    const VALUE = 'value';

    /**
     * @param string|null $factId
     * @return ChuckFact
     */
    public function setId(?string $factId): ChuckFact
    {
        return $this->setData(self::ID, $factId);
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->_getData(self::ID);
    }

    /**
     * @param string|null $iconUrl
     * @return ChuckFact
     */
    public function setIconUrl(?string $iconUrl): ChuckFact
    {
        return $this->setData(self::ICON_URL, $iconUrl);
    }

    /**
     * @return string|null
     */
    public function getIconUrl(): ?string
    {
        return $this->_getData(self::ICON_URL);
    }

    /**
     * @param string|null $url
     * @return ChuckFact
     */
    public function setUrl(?string $url): ChuckFact
    {
        return $this->setData(self::URL, $url);
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->_getData(self::URL);
    }

    /**
     * @param string|null $value
     * @return ChuckFact
     */
    public function setValue(?string $value): ChuckFact
    {
        return $this->setData(self::VALUE, $value);
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->_getData(self::VALUE);
    }
}
