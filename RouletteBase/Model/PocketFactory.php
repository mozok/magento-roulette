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

namespace Mozok\RouletteBase\Model;

use Magento\Framework\ObjectManagerInterface;
use Mozok\RouletteBase\Api\PocketInterface;

class PocketFactory
{
    /**
     * Object Manager
     *
     * @var ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Construct
     *
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Create model
     *
     * @param string $className
     * @param mixed[] $data
     * @return PocketInterface
     * @throws \InvalidArgumentException
     */
    public function create($className, array $data = [])
    {
        $model = $this->objectManager->create($className, $data);

        if (!$model instanceof PocketInterface) {
            throw new \InvalidArgumentException(
                'Type "' . $className . '" is not instance on ' . PocketInterface::class
            );
        }

        return $model;
    }
}
