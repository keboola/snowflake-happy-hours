<?php

declare(strict_types=1);

namespace Keboola\SnowflakeHappyHours\Tests;

use Keboola\SnowflakeHappyHours\Command\AlterWarehouse;
use Keboola\SnowflakeHappyHours\Config;
use Keboola\SnowflakeHappyHours\ConfigDefinition;
use PHPUnit\Framework\TestCase;

class AlterWarehouseCommandTest extends TestCase
{
    public function testCommand(): void
    {
        $configArr = [
            'parameters' => [
                'host' => 'reddwarf',
                'user' => 'arnold',
                '#password' => 'rimmer',
                'min_cluster_count' => 1,
                'max_cluster_count' => 5,
                'warehouse_size' => 'SMALL',
                'warehouse' => 'jidas',
                'max_concurrency_level' => 6,
            ],
        ];
        $config = new Config($configArr, new ConfigDefinition());

        $command = new AlterWarehouse($config);
        $expected = "ALTER WAREHOUSE \"jidas\" SET
WAREHOUSE_SIZE = 'SMALL'
MIN_CLUSTER_COUNT = 1
MAX_CLUSTER_COUNT = 5
MAX_CONCURRENCY_LEVEL = 6;";
        $this->assertSame($expected, $command->getSQL());
    }
}
