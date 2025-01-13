<?php

declare(strict_types=1);

namespace Setono\ConsentBundle\Tests\Checker;

use PHPUnit\Framework\TestCase;
use Setono\Consent\DefaultConsents;
use Setono\ConsentBundle\Checker\StaticConsentChecker;

final class StaticConsentCheckerTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider getGrantedConsents
     */
    public function it_grants(string $consent): void
    {
        $checker = self::getChecker();
        self::assertTrue($checker->isGranted($consent));
    }

    /**
     * @test
     *
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
            [DefaultConsents::CONSENT_MARKETING],
            [DefaultConsents::CONSENT_FUNCTIONAL],
        ];
    }

    /**
     * @return list<array{0: string}>
     */
    public function getGrantedConsents(): array
    {
        return [
            [DefaultConsents::CONSENT_STATISTICAL],
            ['random'],
        ];
    }

    private static function getChecker(): StaticConsentChecker
    {
        return new StaticConsentChecker([
            DefaultConsents::CONSENT_MARKETING => false,
            DefaultConsents::CONSENT_FUNCTIONAL => false,
            DefaultConsents::CONSENT_STATISTICAL => true,
            'random' => true,
        ]);
    }
}
