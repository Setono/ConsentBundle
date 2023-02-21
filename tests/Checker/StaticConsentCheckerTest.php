<?php

declare(strict_types=1);

namespace Setono\ConsentBundle\Tests\Checker;

use PHPUnit\Framework\TestCase;
use Setono\Consent\Consents;
use Setono\ConsentBundle\Checker\StaticConsentChecker;

final class StaticConsentCheckerTest extends TestCase
{
    /**
     * @test
     * @dataProvider getGrantedConsents
     */
    public function it_grants(string $consent): void
    {
        $checker = self::getChecker();
        self::assertTrue($checker->isGranted($consent));
    }

    /**
     * @test
     * @dataProvider getDeniedConsents
     */
    public function it_denies(string $consent): void
    {
        $checker = self::getChecker();
        self::assertFalse($checker->isGranted($consent));
    }

    /**
     * @return list<array{0: string}>
     */
    public function getDeniedConsents(): array
    {
        return [
            [Consents::CONSENT_MARKETING],
            [Consents::CONSENT_PREFERENCES],
        ];
    }

    /**
     * @return list<array{0: string}>
     */
    public function getGrantedConsents(): array
    {
        return [
            [Consents::CONSENT_STATISTICS],
            ['random'],
        ];
    }

    private static function getChecker(): StaticConsentChecker
    {
        return new StaticConsentChecker([
            Consents::CONSENT_MARKETING => false,
            Consents::CONSENT_PREFERENCES => false,
            Consents::CONSENT_STATISTICS => true,
            'random' => true,
        ]);
    }
}
