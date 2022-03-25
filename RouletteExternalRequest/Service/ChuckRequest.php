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

use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\Serialize\SerializerInterface;
use Mozok\RouletteExternalRequest\Model\Data\ChuckFact;
use Mozok\RouletteExternalRequest\Model\Data\ChuckFactFactory;
use Psr\Http\Message\ResponseInterface;

/**
 * Get random Chuck Norris Fact
 */
class ChuckRequest
{
    const API_REQUEST_URI = 'https://api.chucknorris.io/';
    const API_REQUEST_ENDPOINT = 'jokes/random/';

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * @var ChuckFactFactory
     */
    private $chuckFactFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        ChuckFactFactory $chuckFactFactory,
        SerializerInterface $serializer
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->chuckFactFactory = $chuckFactFactory;
        $this->serializer = $serializer;
    }

    /**
     * @return ChuckFact
     */
    public function execute(): ChuckFact
    {
        $response = $this->doRequest(static::API_REQUEST_ENDPOINT);
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents();

        /** @var ChuckFact $chuckFact */
        $chuckFact = $this->chuckFactFactory->create();

        return $this->hydrateChuckFact($chuckFact, $responseContent);
    }

    /**
     * Do API request with provided params
     *
     * @param string $uriEndpoint
     * @param array<mixed> $params
     * @param string $requestMethod
     *
     * @return ResponseInterface
     */
    private function doRequest(
        string $uriEndpoint,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
    ): ResponseInterface {
        /** @var Client $client */
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => self::API_REQUEST_URI
        ]]);

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
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
