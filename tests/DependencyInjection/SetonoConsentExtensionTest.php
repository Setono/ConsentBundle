<?php

declare(strict_types=1);

namespace Setono\ConsentBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\Consent\Consents;
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

        $this->assertContainerBuilderHasParameter('setono_consent.consents', [
            Consents::CONSENT_MARKETING => false,
            Consents::CONSENT_PREFERENCES => false,
            Consents::CONSENT_STATISTICS => false,
        ]);
    }

    /**
     * @test
     */
    public function it_allows_setting_default_values_and_custom_consents(): void
    {
        $this->load([
            'consents' => [
                Consents::CONSENT_STATISTICS => true,
                'custom_consent' => true,
            ],
        ]);

        $this->assertContainerBuilderHasParameter('setono_consent.consents', [
            Consents::CONSENT_MARKETING => false,
            Consents::CONSENT_PREFERENCES => false,
            Consents::CONSENT_STATISTICS => true,
            'custom_consent' => true,
        ]);
    }
}
