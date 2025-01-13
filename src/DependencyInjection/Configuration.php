<?php

declare(strict_types=1);

namespace Setono\ConsentBundle\DependencyInjection;

use Setono\Consent\ConsentCheckerInterface;
use Setono\ConsentBundle\Checker\StaticConsentChecker;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('setono_consent');

        $rootNode = $treeBuilder->getRootNode();

        /** @psalm-suppress MixedMethodCall, PossiblyNullReference, PossiblyUndefinedMethod, UndefinedInterfaceMethod */
        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('consent_checker')
                    ->defaultValue(StaticConsentChecker::class)
                    ->cannotBeEmpty()
                    ->info(sprintf('The service id of the consent checker. Must implement %s', ConsentCheckerInterface::class))
                ->end()
                ->arrayNode('consents')
                    ->booleanPrototype()
        ;

        return $treeBuilder;
    }
}
