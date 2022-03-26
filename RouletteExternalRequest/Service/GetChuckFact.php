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

use Magento\Framework\Serialize\SerializerInterface;
use Mozok\RouletteExternalRequest\Model\Data\ChuckFact;
use Mozok\RouletteExternalRequest\Model\Data\ChuckFactFactory;

/**
 * Get random Chuck Norris Fact
 */
class GetChuckFact
{
    const API_REQUEST_URL = 'https://api.chucknorris.io/jokes/random/';

    /**
     * @var ChuckFactFactory
     */
    private $chuckFactFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var \Mozok\RouletteExternalRequest\Service\DoApiRequest
     */
    private $doApiRequest;

    /**
     * @param DoApiRequest $doApiRequest
     * @param ChuckFactFactory $chuckFactFactory
     * @param SerializerInterface $serializer
     */
    public function __construct(
        DoApiRequest $doApiRequest,
        ChuckFactFactory $chuckFactFactory,
        SerializerInterface $serializer
    ) {
        $this->doApiRequest = $doApiRequest;
        $this->chuckFactFactory = $chuckFactFactory;
        $this->serializer = $serializer;
    }

    /**
     * @return ChuckFact
     */
    public function execute(): ChuckFact
    {
        $response = $this->doApiRequest->execute(self::API_REQUEST_URL);
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents();

        /** @var ChuckFact $chuckFact */
        $chuckFact = $this->chuckFactFactory->create();

        return $this->hydrateChuckFact($chuckFact, $responseContent);
    }

    /**
     * @param ChuckFact $chuckFact
     * @param string $responseContent
     * @return ChuckFact
     */
    private function hydrateChuckFact(ChuckFact $chuckFact, string $responseContent): ChuckFact
    {
        $response = $this->serializer->unserialize($responseContent);

        if (is_array($response)) {
            $chuckFact->setId($response[ChuckFact::ID] ?? null);
            $chuckFact->setIconUrl($response[ChuckFact::ICON_URL] ?? null);
            $chuckFact->setUrl($response[ChuckFact::URL] ?? null);
            $chuckFact->setValue($response[ChuckFact::VALUE] ?? null);
        }

        return $chuckFact;
    }
}
