<?php

declare(strict_types=1);

namespace Setono\ConsentBundle\Checker;

use Setono\Consent\ConsentCheckerInterface;

final class StaticConsentChecker implements ConsentCheckerInterface
{
    public function __construct(
        /**
         * @var array<string, bool> $consents
         */
        private readonly array $consents,
    ) {
    }

    public function isGranted(string $consent): bool
    {
        return isset($this->consents[$consent]) && $this->consents[$consent];
    }
}
