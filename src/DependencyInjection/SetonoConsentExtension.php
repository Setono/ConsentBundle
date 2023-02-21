<?php

declare(strict_types=1);

namespace Setono\ConsentBundle\DependencyInjection;

use Setono\Consent\Consents;
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
         * @var array{consents: array<string, bool>} $config
         */
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);

        $consents = array_merge([
            Consents::CONSENT_MARKETING => false,
            Consents::CONSENT_PREFERENCES => false,
            Consents::CONSENT_STATISTICS => false,
        ], $config['consents']);

        $container->setParameter('setono_consent.consents', $consents);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}
