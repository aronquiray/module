<?php

namespace HalcyonLaravel\Module\Tests;

use Illuminate\Database\Schema\Blueprint;
use App\Models\User;
// use App\Models\Content;
// use App\Models\Core\Page;
// use App\Models\Core\PageSoftDelete;
use Orchestra\Testbench\TestCase as Orchestra;
use Route;
use View;

class TestCase extends Orchestra
{
    protected $user;
    protected $admin;
    protected $content;
    protected $page;
    
    public function setUp()
    {
        parent::setUp();
        $this->setUpDatabase($this->app);
        $this->setUpSeed();
    }


    public function tearDown()
    {
        parent::tearDown();
    }

    protected function setUpSeed()
    {
        $this->admin = User::create([
            'first_name' => 'Istrator',
            'last_name' => 'Admin',
        ]);

        $this->user = User::create([
            'first_name' => 'Basic',
            'last_name' => 'User',
        ]);
    }

    /**
     * Set up the database.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase($app)
    {
        $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Resolve application HTTP Kernel implementation.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function resolveApplicationHttpKernel($app)
    {
        $app->singleton('Illuminate\Contracts\Http\Kernel', 'App\Http\Kernel');
    }



    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }


    protected function getPackageAliases($app)
    {
        return [
            "DataTables" => "Yajra\\DataTables\\Facades\\DataTables"
        ];
    }

    protected function getPackageProviders($app)
    {
        return [
            "HalcyonLaravel\\Module\\Providers\\ModuleServiceProvider",

            // --

            "HalcyonLaravel\\Base\\Providers\\BaseServiceProvider",
            "HalcyonLaravel\\Base\\Providers\\EventServiceProvider",

            "Yajra\\DataTables\\DataTablesServiceProvider",
            "Spatie\\Permission\\PermissionServiceProvider",
        ];
    }
}
