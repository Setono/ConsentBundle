<?php

declare(strict_types=1);

namespace Setono\ConsentBundle\Checker;

use Setono\Consent\ConsentCheckerInterface;

final class StaticConsentChecker implements ConsentCheckerInterface
{
    /** @var array<string, bool> */
    private array $consents;

    /**
     * @param array<string, bool> $consents
     */
    public function __construct(array $consents)
    {
        $this->consents = $consents;
    }

    public function isGranted(string $consent): bool
    {
        return isset($this->consents[$consent]) && $this->consents[$consent];
    }
}
