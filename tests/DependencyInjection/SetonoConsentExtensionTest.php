<?php

declare(strict_types=1);

namespace Setono\ConsentBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\ConsentBundle\DependencyInjection\SetonoConsentExtension;

/**
 * @covers \Setono\ConsentBundle\DependencyInjection\SetonoConsentExtension
 */
final class SetonoConsentExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new SetonoConsentExtension(),
        ];
    }

    /**
     * @test
     */
    public function after_loading_the_correct_parameters_has_been_set(): void
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('setono_consent.marketing_granted', false);
        $this->assertContainerBuilderHasParameter('setono_consent.preferences_granted', false);
        $this->assertContainerBuilderHasParameter('setono_consent.statistics_granted', false);
    }
}
