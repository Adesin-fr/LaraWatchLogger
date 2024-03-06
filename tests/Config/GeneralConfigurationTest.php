<?php

namespace Larawatch\Logger\Tests\Config;

use Larawatch\Logger\Tests\TestCase;

class GeneralConfigurationTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function it_will_return_the_array_of_log_levels_to_watch()
    {
        $expected = [
            'emergency',
            'alert',
            'critical',
            'error',
            'warning'
        ];

        config()->set('larawatch.logLevelsWatched', $expected);

        $actual = config('larawatch.logLevelsWatched');

        $this->assertEquals($expected, $actual);
    }

}
