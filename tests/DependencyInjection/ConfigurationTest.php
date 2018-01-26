<?php

declare(strict_types=1);

/*
 * (c) Christian Gripp <mail@core23.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core23\AntiSpamBundle\Tests\DependencyInjection;

use Core23\AntiSpamBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

final class ConfigurationTest extends TestCase
{
    public function testDefaultOptions(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), [[
        ]]);

        $expected = [
            'time' => [
                'min'        => 5,
                'max'        => 3600,
                'global'     => false,
            ],
            'honeypot' => [
                'field'      => 'email_address',
                'class'      => 'hidden',
                'global'     => false,
                'provider'   => 'core23_antispam.provider.session',
            ],
        ];

        $this->assertSame($expected, $config);
    }

    public function testOptions(): void
    {
        $processor = new Processor();

        $config = $processor->processConfiguration(new Configuration(), [[
            'time' => [
                'min'        => 0,
                'max'        => 600,
                'global'     => true,
            ],
            'honeypot' => [
                'field'      => 'custom',
                'class'      => 'hide',
                'global'     => true,
                'provider'   => 'core23_antispam.provider.custom',
            ],
        ]]);

        $expected = [
            'time' => [
                'min'        => 0,
                'max'        => 600,
                'global'     => true,
            ],
            'honeypot' => [
                'field'      => 'custom',
                'class'      => 'hide',
                'global'     => true,
                'provider'   => 'core23_antispam.provider.custom',
            ],
        ];

        $this->assertSame($expected, $config);
    }
}
