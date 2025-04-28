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
            'host' => $this->getStringValue(['parameters', 'host']),
            'user' => $this->getStringValue(['parameters', 'user']),
            'password' => $this->getStringValue(['parameters', '#password'], ''),
        ];

        if ($this->hasPrivateKey()) {
            $options['privateKey'] = $this->getStringValue(['parameters', '#privateKey']);
        }

        return $options;
    }

    public function getHost(): string
    {
        return $this->getStringValue(['parameters', 'host']);
    }

    public function getWarehouse(): string
    {
        return $this->getStringValue(['parameters', 'warehouse']);
    }

    public function getMinClusterCount(): int
    {
        return $this->getIntValue(['parameters', 'min_cluster_count']);
    }

    public function getMaxClusterCount(): int
    {
        return $this->getIntValue(['parameters', 'max_cluster_count']);
    }

    public function getMaxConcurrencyLevel(): int
    {
        return $this->getIntValue(['parameters', 'max_concurrency_level']);
    }

    public function getWarehouseSize(): string
    {
        return $this->getStringValue(['parameters', 'warehouse_size']);
    }

    public function hasPrivateKey(): bool
    {
        return !empty($this->getValue(['parameters', '#privateKey'], ''));
    }
}
