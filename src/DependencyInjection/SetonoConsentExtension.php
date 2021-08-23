<?php

declare(strict_types=1);

namespace Setono\ConsentBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoConsentExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        /**
         * @psalm-suppress PossiblyNullArgument
         *
         * @var array{marketing_granted: bool, preferences_granted: bool, statistics_granted: bool} $config
         */
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);

        $container->setParameter('setono_consent.marketing_granted', $config['marketing_granted']);
        $container->setParameter('setono_consent.preferences_granted', $config['preferences_granted']);
        $container->setParameter('setono_consent.statistics_granted', $config['statistics_granted']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}
