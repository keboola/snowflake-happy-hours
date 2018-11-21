<?php

declare(strict_types=1);

namespace Keboola\SnowflakeHappyHours\Tests;

use Keboola\SnowflakeHappyHours\Config;
use Keboola\SnowflakeHappyHours\ConfigDefinition;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

class ConfigDefinitionTest extends TestCase
{
    public function testValidConfig(): void
    {
        $config = new Config($this->provideValidConfig(), new ConfigDefinition());

        $this->assertNotEmpty($config->getConnectionConfig());
    }

    /**
     * @dataProvider invalidParametersProvider
     */
    public function testInvalidConfig(array $invalidPart): void
    {
        $params = array_merge($this->provideValidConfig()['parameters'], $invalidPart);
        $this->expectException(InvalidConfigurationException::class);
        (new Config(['parameters' => $params], new ConfigDefinition()));
    }

    public function invalidParametersProvider(): array
    {
        return [
            'empty-warehouse' => [
                ['warehouse' => ''],
            ],
            'invalid-size-of-warehouse' => [
                ['warehouse_size' => 'mrte-velky'],
            ],
            'empty-size-of-warehouse' => [
                ['warehouse_size' => ''],
            ],
            'too-large-min-count' => [
                ['min_cluster_count' => 50],
            ],
            'too-small-max-count' => [
                ['max_cluster_count' => 1],
            ],
            'too-low-concurrency-level' => [
                ['max_concurency_level' => 2],
            ],
            'too-large-concurrency-level' => [
                ['max_concurency_level' => 15],
            ],
            'no-user' => [
                ['user' => ''],
            ],
            'no-password' => [
                ['password' => ''],
            ],
            'no-host' => [
                ['host' => ''],
            ],
        ];
    }

    private function provideValidConfig(): array
    {
        return [
            'parameters' => [
                'warehouse' => 'test-ware',
                'warehouse_size' => 'SMALL',
                'min_cluster_count' => 1,
                'max_cluster_count' => 4,
                'max_concurrency_level' => 5,
                'user' => 'user',
                '#password' => 'pass',
                'host' => 'https://host.com',
            ],
        ];
    }
}
