<?php

declare(strict_types=1);

namespace Setono\ConsentBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('setono_consent');

        $rootNode = $treeBuilder->getRootNode();

        /** @psalm-suppress MixedMethodCall, PossiblyNullReference, PossiblyUndefinedMethod */
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('marketing_granted')
                    ->defaultFalse()
                    ->info('The default value of the marketing permission')
                ->end()
                ->booleanNode('preferences_granted')
                    ->defaultFalse()
                    ->info('The default value of the preferences permission')
                ->end()
                ->booleanNode('statistics_granted')
                    ->defaultFalse()
                    ->info('The default value of the statistics permission')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
