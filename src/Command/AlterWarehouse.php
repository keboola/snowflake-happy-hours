<?php

declare(strict_types=1);

namespace Keboola\SnowflakeHappyHours\Command;

use Keboola\SnowflakeHappyHours\Config;

class AlterWarehouse
{
    /**
     * @var Config
     */
    private $config;


    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getSQL(): string
    {
        return sprintf(
            "ALTER WAREHOUSE \"%s\" SET
WAREHOUSE_SIZE = '%s'
MIN_CLUSTER_COUNT = %s
MAX_CLUSTER_COUNT = %s
MAX_CONCURRENCY_LEVEL = %s;",
            $this->config->getWarehouse(),
            $this->config->getWarehouseSize(),
            $this->config->getMinClusterCount(),
            $this->config->getMaxClusterCount(),
            $this->config->getMaxConcurrencyLevel()
        );
    }
}
