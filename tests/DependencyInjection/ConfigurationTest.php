<?php

declare(strict_types=1);

namespace Setono\ConsentBundle\Tests\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Setono\ConsentBundle\DependencyInjection\Configuration;

/**
 * @covers \Setono\ConsentBundle\DependencyInjection\Configuration
 */
final class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration(): Configuration
    {
        return new Configuration();
    }

    /**
     * @test
     */
    public function it_processes_configuration(): void
    {
        $this->assertProcessedConfigurationEquals([
            ['consents' => [
                'marketing' => false,
                'preferences' => false,
                'statistics' => true,
                'random' => true,
            ]],
        ], [
            'consents' => [
                'marketing' => false,
                'preferences' => false,
                'statistics' => true,
                'random' => true,
            ],
        ]);
    }
}
