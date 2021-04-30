<?php

declare(strict_types=1);

namespace Keboola\SnowflakeHappyHours;

use Keboola\Component\Config\BaseConfigDefinition;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class ConfigDefinition extends BaseConfigDefinition
{

    private const POSSIBLE_WAREHOUSE_SIZES = ['XSMALL', 'SMALL', 'MEDIUM', 'LARGE'];

    protected function getParametersDefinition(): ArrayNodeDefinition
    {
        $parametersNode = parent::getParametersDefinition();
        // @formatter:off
        /** @noinspection NullPointerExceptionInspection */
        $parametersNode
            ->children()
                ->scalarNode('warehouse')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('warehouse_size')
                    ->isRequired()
                    ->validate()
                        ->ifNotInArray(self::POSSIBLE_WAREHOUSE_SIZES)
                        ->thenInvalid(
                            sprintf(
                                'Size must be one of %s',
                                implode(',', self::POSSIBLE_WAREHOUSE_SIZES)
                            )
                        )
                    ->end()
                ->end()
                ->integerNode('min_cluster_count')
                    ->isRequired()
                    ->max(2)
                ->end()
                ->integerNode('max_cluster_count')
                    ->isRequired()
                    ->min(1)
                ->end()
                ->integerNode('max_concurrency_level')
                    ->isRequired()
                    ->min(4)->max(12)
                ->end()
                ->scalarNode('user')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('#password')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('host')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;
        // @formatter:on
        return $parametersNode;
    }
}
