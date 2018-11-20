<?php

declare(strict_types=1);

namespace Keboola\SnowflakeHappyHours\Command;

class AlterWarehouse
{
    /**
     * @var int
     */
    private $minClusterSize;

    /**
     * @var int
     */
    private $maxClusterSize;

    /**
     * @var int
     */
    private $maxConcurencyLevel;

    /**
     * @var string
     */
    private $warehouseSize;

    /**
     * @var string
     */
    private $warehouse;


    public function __construct(
        string $warehouse,
        int $minClusterSize,
        int $maxClusterSize,
        int $maxConcurencyLevel,
        string $warehouseSize
    ) {
        $this->warehouse = $warehouse;
        $this->minClusterSize = $minClusterSize;
        $this->maxClusterSize = $maxClusterSize;
        $this->maxConcurencyLevel = $maxConcurencyLevel;
        $this->warehouseSize = $warehouseSize;
    }

    public function getSQL(): string
    {
        return sprintf(
            "ALTER WAREHOUSE \"%s\" SET
WAREHOUSE_SIZE = '%s'
MIN_CLUSTER_COUNT = %s
MAX_CLUSTER_COUNT = %s
MAX_CONCURRENCY_LEVEL = %s;",
            $this->warehouse,
            $this->warehouseSize,
            $this->minClusterSize,
            $this->maxClusterSize,
            $this->maxConcurencyLevel
        );
    }
}
