<?php

declare(strict_types=1);

namespace Keboola\SnowflakeHappyHours;

use Keboola\Component\Config\BaseConfig;

class Config extends BaseConfig
{
    /**
     * @return array<string, string>
     */
    public function getConnectionConfig(): array
    {
        $options = [
            'host' => $this->getValue(['parameters', 'host']),
            'user' => $this->getValue(['parameters', 'user']),
            'password' => $this->getValue(['parameters', '#password'], ''),
        ];

        if ($this->hasKeyPair()) {
            $options['keyPair'] = $this->getValue(['parameters', '#keyPair']);
        }

        return $options;
    }

    public function getHost(): string
    {
        return $this->getValue(['parameters', 'host']);
    }

    public function getWarehouse(): string
    {
        return $this->getValue(['parameters', 'warehouse']);
    }

    public function getMinClusterCount(): int
    {
        return $this->getValue(['parameters', 'min_cluster_count']);
    }

    public function getMaxClusterCount(): int
    {
        return $this->getValue(['parameters', 'max_cluster_count']);
    }

    public function getMaxConcurrencyLevel(): int
    {
        return $this->getValue(['parameters', 'max_concurrency_level']);
    }

    public function getWarehouseSize(): string
    {
        return $this->getValue(['parameters', 'warehouse_size']);
    }

    public function hasKeyPair(): bool
    {
        return !empty($this->getValue(['parameters', '#keyPair'], ''));
    }
}
