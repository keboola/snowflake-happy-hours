<?php

declare(strict_types=1);

namespace Keboola\SnowflakeHappyHours;

use Keboola\Component\BaseComponent;
use Keboola\Component\UserException;
use Keboola\Db\Import\Exception as DbException;
use Keboola\Db\Import\Snowflake\Connection as SnowflakeConnection;
use Keboola\SnowflakeHappyHours\Command\AlterWarehouse as AlterWarehouseCommand;

class Component extends BaseComponent
{
    public function run(): void
    {
        /** @var Config $config */
        $config = $this->getConfig();
        $this->getLogger()->info(sprintf("Connecting to host %s", $config->getHost()));
        try {
            $connection = new SnowflakeConnection($config->getConnectionConfig());
        } catch (DbException $e) {
            throw new UserException(
                'Cannot connect to snowflake. Please check your credentials',
                $e->getCode(),
                $e
            );
        }
        $command = new AlterWarehouseCommand(
            $config->getWarehouse(),
            $config->getMinClusterCount(),
            $config->getMaxClusterCount(),
            $config->getMaxConcurencyLevel(),
            $config->getWarehouseSize()
        );

        $this->getLogger()->info(sprintf("Running query %s", $command->getSQL()));
        $connection->query($command->getSQL());
        $this->getLogger()->info(sprintf("Done"));
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
