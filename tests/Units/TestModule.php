<?php

namespace HalcyonLaravel\Module\Tests\Features;

use HalcyonLaravel\Module\Tests\TestCase;

class TestModule extends TestCase
{
    public function testCreateUpdate()
    {
        $this->artisan('module:make', [
            'name' => 'test'
        ]);
        $this->assertEquals('Module test'."\n", \Artisan::output());
    }
}
