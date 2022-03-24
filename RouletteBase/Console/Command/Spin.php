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

namespace Mozok\RouletteBase\Console\Command;

use Mozok\RouletteBase\Model\RouletteManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Spin extends Command
{
    /**
     * @var RouletteManager
     */
    private $rouletteManager;

    /**
     * @param RouletteManager $rouletteManager
     * @param string|null $name
     */
    public function __construct(
        RouletteManager $rouletteManager,
        string $name = null
    ) {
        $this->rouletteManager = $rouletteManager;
        parent::__construct($name);
    }

    /**
     * Configures the Spin command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('roulette:spin');
        $this->setDescription('Just spin the rulette and see what you get!');
        parent::configure();
    }

    /**
     * CLI command description
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $result = $this->rouletteManager->spin();
            if ($result !== null) {
                $output->writeln($result);
            }
        } catch (\Exception $exception) {
            $output->writeln($exception->getMessage());
        }
        return 0;
    }
}
