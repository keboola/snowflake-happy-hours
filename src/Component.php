<?php

declare(strict_types=1);

namespace Keboola\SnowflakeHappyHours;

use Keboola\Component\BaseComponent;
use Keboola\Component\UserException;
use Keboola\Db\Import\Exception as DbException;
use Keboola\SnowflakeDbAdapter\Connection as SnowflakeConnection;
use Keboola\SnowflakeDbAdapter\Exception\SnowflakeDbAdapterException;
use Keboola\SnowflakeHappyHours\Command\AlterWarehouse as AlterWarehouseCommand;

class Component extends BaseComponent
{
    protected function run(): void
    {
        /** @var Config $config */
        $config = $this->getConfig();
        $this->getLogger()->info(sprintf('Connecting to host %s', $config->getHost()));
        try {
            $connection = new SnowflakeConnection($config->getConnectionConfig());
        } catch (SnowflakeDbAdapterException $e) {
            throw new UserException(
                'Cannot connect to snowflake. Please check your credentials',
                $e->getCode(),
                $e,
            );
        }
        $command = new AlterWarehouseCommand($config, $connection, $this->getLogger(), 40);

        $this->getLogger()->info(sprintf('Running query %s', $command->getSQL()));
        $command->executeAlter();
        $this->getLogger()->info(sprintf('Done'));
    }

    protected function getConfigClass(): string
    {
        return Config::class;
    }

    protected function getConfigDefinitionClass(): string
    {
        return ConfigDefinition::class;
    }
}
