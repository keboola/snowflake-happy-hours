<?php

declare(strict_types=1);

namespace Keboola\SnowflakeHappyHours\Tests;

use Keboola\SnowflakeHappyHours\Command\AlterWarehouse;
use PHPUnit\Framework\TestCase;

class AlterWarehouseCommandTest extends TestCase
{
    public function testCommand(): void
    {
        $command = new AlterWarehouse('wrh', 1, 5, 6, 'X-SMALL');
        $expected = "ALTER WAREHOUSE \"wrh\" SET
WAREHOUSE_SIZE = 'X-SMALL'
MIN_CLUSTER_COUNT = 1
MAX_CLUSTER_COUNT = 5
MAX_CONCURRENCY_LEVEL = 6;";
        $this->assertSame($expected, $command->getSQL());
    }
}
