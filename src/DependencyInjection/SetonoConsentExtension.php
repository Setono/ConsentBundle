<?php

declare(strict_types=1);

namespace Setono\ConsentBundle\DependencyInjection;

use Setono\Consent\ConsentCheckerInterface;
use Setono\Consent\Consents;
use Setono\Consent\DefaultConsents;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class SetonoConsentExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        /**
         * @psalm-suppress PossiblyNullArgument
         *
         * @var array{consent_checker: string, consents: array<string, bool>} $config
         */
        $config = $this->processConfiguration($this->getConfiguration([], $container), $configs);

        $consents = array_merge([
            DefaultConsents::CONSENT_MARKETING => false,
            DefaultConsents::CONSENT_FUNCTIONAL => false,
            DefaultConsents::CONSENT_STATISTICAL => false,
        ], $config['consents']);

        $container->setParameter('setono_consent.consents', $consents);

        // validate the consent checker
        $consentChecker = $container->getDefinition($config['consent_checker']);
        if (!is_a($consentChecker->getClass(), ConsentCheckerInterface::class, true)) {
            throw new InvalidArgumentException(sprintf('The consent checker must implement %s', ConsentCheckerInterface::class));
        }

        $alias = new Alias($config['consent_checker']);
        $alias->setDeprecated('setono/consent-bundle', '1.2', sprintf('The "%%alias_id%%" service is deprecated. You should use the "%s" alias instead.', ConsentCheckerInterface::class));

        $container->setAlias('setono_consent.consent_checker.default', $alias);
        $container->setAlias(ConsentCheckerInterface::class, $config['consent_checker']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.xml');
    }
}
