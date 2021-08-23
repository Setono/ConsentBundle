# Symfony Consent Bundle

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
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

The default configuration has all permissions (marketing, preferences, and statistics) set to `false`. If you want to
change these defaults, you can easily do so:

```yaml
# config/packages/setono_consent.yaml

setono_consent:
    marketing_granted: true
    preferences_granted: true
    statistics_granted: true
```

The above configuration will effectively changes the default consent to `true` for all permissions.

## Usage

The bundle provides a default consent context that you can easily inject and use inside your application:

```php
<?php
use Setono\Consent\Context\ConsentContextInterface;

final class YourMarketingTrackingService
{
    private ConsentContextInterface $consentContext;
    
    public function __construct(ConsentContextInterface $consentContext) {
        $this->consentContext = $consentContext;
    }
    
    public function track(): void
    {
        if(!$this->consentContext->getConsent()->isMarketingConsentGranted()) {
            return;
        }
        
        // do your marketing tracking
    }
}
```

[ico-version]: https://poser.pugx.org/setono/consent-bundle/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/consent-bundle/v/unstable
[ico-license]: https://poser.pugx.org/setono/consent-bundle/license
[ico-github-actions]: https://github.com/Setono/ConsentBundle/workflows/build/badge.svg
[ico-code-coverage]: https://codecov.io/gh/Setono/ConsentBundle/branch/master/graph/badge.svg
[ico-infection]: https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2FSetono%2FConsentBundle%2Fmaster

[link-packagist]: https://packagist.org/packages/setono/consent-bundle
[link-github-actions]: https://github.com/Setono/ConsentBundle/actions
[link-code-coverage]: https://codecov.io/gh/Setono/ConsentBundle
[link-infection]: https://dashboard.stryker-mutator.io/reports/github.com/Setono/ConsentBundle/master
