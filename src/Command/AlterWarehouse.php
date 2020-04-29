<?php

declare(strict_types=1);

namespace Keboola\SnowflakeHappyHours\Command;

use Keboola\Db\Import\Snowflake\Connection;
use Keboola\SnowflakeHappyHours\Config;
use Psr\Log\LoggerInterface;
use Retry\BackOff\ExponentialBackOffPolicy;
use Retry\Policy\SimpleRetryPolicy;
use Retry\RetryProxy;

class AlterWarehouse
{
    /** @var Config */
    private $config;

    /** @var Connection*/
    private $connection;

    /** @var LoggerInterface */
    private $logger;

    /** @var int */
    private $retryAttempts;


    public function __construct(Config $config, Connection $connection, LoggerInterface $logger, int $attempts)
    {
        $this->config = $config;
        $this->connection = $connection;
        $this->logger = $logger;
        $this->retryAttempts = $attempts;
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

    public function executeAlter(): void
    {
        $retryPolicy = new SimpleRetryPolicy($this->retryAttempts);
        $backOffPolicy = new ExponentialBackOffPolicy();

        $proxy = new RetryProxy($retryPolicy, $backOffPolicy, $this->logger);
        $proxy->call(function (): void {
            $this->connection->query($this->getSQL());
        });
    }
}
