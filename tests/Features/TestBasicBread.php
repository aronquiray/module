<?php

namespace HalcyonLaravel\Module\Tests\Features;

use  HalcyonLaravel\Module\Tests\TestCase;


use HalcyonLaravel\Base\Events\BaseStoringEvent;
use HalcyonLaravel\Base\Events\BaseStoredEvent;
use HalcyonLaravel\Base\Events\BaseUpdatingEvent;
use HalcyonLaravel\Base\Events\BaseUpdatedEvent;
use Route;
use App\Models\Core\DummyClass;

class TestBasicBread extends TestCase
{

    // public function setUp()
    // {
    //     parent::setUp();
    //     $this->artisan('module:make',[
    //         'name' => 'dummy class'
    //     ]);
    //     Route::group([
    //         'namespace' => 'App\Http\Controllers\Backend',
    //         'prefix' => 'admin.',
    //     ], function () {
    //         include_once __DIR__ . '/../tmp/routes/backend/core/dummyClass.php';
    //     });

    //     include_once __DIR__ . '/../../src/Commands/stubs/basic/migration.stub';

    //     shell_exec('composer dumpautoload -o');
    //     (new \CreateDummyClassesTable)->up();
    // }


    // public function tearDown()
    // {
    //     parent::tearDown();
    //     shell_exec('rm -rf tests/tmp//app');
    //     shell_exec('rm -rf tests/tmp/resources');
    //     shell_exec('rm -rf tests/tmp/routes');
    //     shell_exec('rm -rf tests/tmp/database');
    // }


    public function testStore()
    {
        $this->artisan('module:make', [
            'name' => 'dummy class'
        ]);
        Route::group([
            'namespace' => 'App\Http\Controllers\Backend',
            'prefix' => 'admin.',
        ], function () {
            include_once __DIR__ . '/../tmp/routes/backend/core/dummyClass.php';
        });

        include_once __DIR__ . '/../../src/Commands/stubs/basic/migration.stub';

        shell_exec('composer dumpautoload -o');
        (new \CreateDummyClassesTable)->up();


        $this->actingAs($this->admin);


        /**
         * ==================================================================================================================
         */

        $this->expectsEvents(BaseStoringEvent::class);
        $this->expectsEvents(BaseStoredEvent::class);

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('POST', route('admin.dummy-class.store'), [
            'name' => 'Salliess',
            'content' => 'description test',
            'description' => 'description',
        ]);

        $dummy =  DummyClass::latest()->first();
        // dd($response);
        $response
            ->assertStatus(302)
            ->assertSessionHas('flash_success', 'Salliess has been created.')
            ->assertRedirect(route('admin.dummy-class.show', $dummy));

        $this->assertDatabaseHas((new DummyClass)->getTable(), [
            'name' => 'Salliess',
            'content' => 'description test',
            'description' => 'description',
        ]);
 


        /**
         * ==================================================================================================================
         * UPDATE
         */
        DummyClass::create([
            'name' => 'old Salliess',
            'content' => 'old description test',
            'description' => 'old description',
        ]);


        $dummy =  DummyClass::latest()->first();


        $dataNew = [
            'name' => 'Salliess',
            'content' => 'description test',
            'description' => 'description',
        ];


        $this->expectsEvents(BaseUpdatingEvent::class);
        $this->expectsEvents(BaseUpdatedEvent::class);

        $response = $this->withHeaders([
            'X-Header' => 'Value',
        ])->json('PUT', route('admin.dummy-class.update', $dummy), $dataNew);
       
        $response
            ->assertStatus(302)
            ->assertSessionHas('flash_success', 'Salliess has been updated.')
            ->assertRedirect(route('admin.dummy-class.show', $dummy));

        $this->assertDatabaseHas((new DummyClass)->getTable(), $dataNew);

        /**
         * ==================================================================================================================
         */






        /**
         * ==================================================================================================================
         */

        shell_exec('rm -rf tests/tmp/app');
        shell_exec('rm -rf tests/tmp/resources');
        shell_exec('rm -rf tests/tmp/routes');
        shell_exec('rm -rf tests/tmp/database');
    }
}
