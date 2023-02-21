# Symfony Consent Bundle

[![Latest Version][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Code Coverage][ico-code-coverage]][link-code-coverage]
[![Mutation testing][ico-infection]][link-infection]

This bundle integrates the [consent contracts](https://github.com/Setono/consent-contracts) into Symfony.

## Installation

```shell
composer require setono/consent-bundle
```

This installs and enables the plugin automatically if you're using Symfony Flex. If not, add the bundle manually
to `bundles.php`.

## Configuration

The default configuration has all (default) consents (marketing, preferences, and statistics) set to `false`. If you want to
change these defaults, you can easily do so:

```yaml
# config/packages/setono_consent.yaml

setono_consent:
    consents:
        marketing: true
        preferences: true
        statistics: true
        random_consent: true # you can easily add your own consents
```

The above configuration will effectively change the default consent to `true` for all permissions.

## Usage

The bundle provides a `StaticConsentChecker` that uses the above `consents` array as an input.
You can then autowire the `ConsentCheckerInterface` and check for a granted consent:

```php
<?php
use Setono\Consent\Consents;
use Setono\Consent\ConsentCheckerInterface;

final class YourMarketingTrackingService
{
    private ConsentCheckerInterface $consentChecker;
    
    public function __construct(ConsentCheckerInterface $consentChecker) {
        $this->consentChecker = $consentChecker;
    }
    
    public function track(): void
    {
        if(!$this->consentChecker->isGranted(Consents::CONSENT_MARKETING)) {
            return;
        }
        
        // do your marketing tracking
    }
}
```

[ico-version]: https://poser.pugx.org/setono/consent-bundle/v/stable
[ico-license]: https://poser.pugx.org/setono/consent-bundle/license
[ico-github-actions]: https://github.com/Setono/ConsentBundle/workflows/build/badge.svg
[ico-code-coverage]: https://codecov.io/gh/Setono/ConsentBundle/branch/1.x/graph/badge.svg
[ico-infection]: https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FSetono%2FConsentBundle%2F1.x

[link-packagist]: https://packagist.org/packages/setono/consent-bundle
[link-github-actions]: https://github.com/Setono/ConsentBundle/actions
[link-code-coverage]: https://codecov.io/gh/Setono/ConsentBundle
[link-infection]: https://dashboard.stryker-mutator.io/reports/github.com/Setono/ConsentBundle/1.x
