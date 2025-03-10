<?php

declare(strict_types=1);

namespace Keboola\SnowflakeHappyHours\Tests;

use Exception;
use Keboola\Component\Logger;
use Keboola\SnowflakeDbAdapter\Connection;
use Keboola\SnowflakeHappyHours\Command\AlterWarehouse;
use Keboola\SnowflakeHappyHours\Config;
use Keboola\SnowflakeHappyHours\ConfigDefinition;
use LogicException;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

class AlterWarehouseCommandTest extends TestCase
{
    /**
     * @return array<string, array<string, string|int>>
     */
    private function getConfig(): array
    {
        return [
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
    }

    public function testCommandSql(): void
    {
        $mock = self::getMockBuilder(Connection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects(self::once())->method('query')->with("ALTER WAREHOUSE \"jidas\" SET
WAREHOUSE_SIZE = 'SMALL'
MIN_CLUSTER_COUNT = 1
MAX_CLUSTER_COUNT = 5
MAX_CONCURRENCY_LEVEL = 6;");
        $config = new Config($this->getConfig(), new ConfigDefinition());

        /** @var Connection $mock */
        $command = new AlterWarehouse($config, $mock, new NullLogger(), 1);
        $command->executeAlter();
    }

    public function testCommandRetryFailure(): void
    {
        $mock = self::getMockBuilder(Connection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mock->expects(self::atLeast(2))
            ->method('query')
            ->willThrowException(new LogicException('Boo!'));
        $config = new Config($this->getConfig(), new ConfigDefinition());

        /** @var Connection $mock */
        $testLogger = new Logger();
        $command = new AlterWarehouse($config, $mock, $testLogger, 2);
        try {
            $command->executeAlter();
            self::fail('Must throw exception');
        } catch (LogicException $e) {
            self::assertStringContainsString('Boo!', $e->getMessage());
        }
    }

    public function testCommandRetrySuccess(): void
    {
        $mock = self::getMockBuilder(Connection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $counter = 0;
        $mock->expects(self::atLeast(2))
            ->method('query')
            ->willReturnCallback(function () use (&$counter): void {
                if ($counter > 2) {
                    return;
                } else {
                    $counter++;
                    throw new Exception('Boo!');
                }
            });
        $config = new Config($this->getConfig(), new ConfigDefinition());

        /** @var Connection $mock */
        $testLogger = new Logger();
        $command = new AlterWarehouse($config, $mock, $testLogger, 5);
        $command->executeAlter();
    }
}
