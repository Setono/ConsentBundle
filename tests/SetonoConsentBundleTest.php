<?php

declare(strict_types=1);

namespace Setono\ConsentBundle\Tests;

use Nyholm\BundleTest\TestKernel;
use Setono\Consent\ConsentCheckerInterface;
use Setono\ConsentBundle\Checker\StaticConsentChecker;
use Setono\ConsentBundle\SetonoConsentBundle;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\KernelInterface;

final class SetonoConsentBundleTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /**
         * @var TestKernel $kernel
         */
        $kernel = parent::createKernel($options);
        $kernel->addTestBundle(SetonoConsentBundle::class);
        $kernel->addTestCompilerPass(new class() implements CompilerPassInterface {
            public function process(ContainerBuilder $container): void
            {
                foreach ($container->getDefinitions() as $id => $definition) {
                    if (stripos($id, 'setono') === 0) {
                        $definition->setPublic(true);
                    }
                }

                foreach ($container->getAliases() as $id => $alias) {
                    if (stripos($id, 'setono') === 0) {
                        $alias->setPublic(true);
                    }
                }
            }
        });
        $kernel->handleOptions($options);

        return $kernel;
    }

    /**
     * @test
     */
    public function it_has_services(): void
    {
        $container = self::getContainer();

        /** @var array<string, array{class: class-string, interface?: class-string}> $services */
        $services = [
            'setono_consent.consent_checker.default' => [
                'class' => StaticConsentChecker::class,
                'interface' => ConsentCheckerInterface::class,
            ],
            ConsentCheckerInterface::class => [
                'class' => StaticConsentChecker::class,
            ],
        ];

        foreach ($services as $id => $service) {
            $this->assertTrue($container->has($id));
            $obj = $container->get($id);
            $this->assertInstanceOf($service['class'], $obj);

            if (isset($service['interface'])) {
                $this->assertInstanceOf($service['interface'], $obj);
            }
        }
    }
}
