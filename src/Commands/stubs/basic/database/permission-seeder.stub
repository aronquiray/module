<?php

use DummyNameSpaceClass\Models\Auth\User;
use DummyNameSpaceClass\Models\DummyPath\DummyClass\DummyClass;
use HalcyonLaravel\Base\Database\Traits\SeederHelper;
use Illuminate\Database\Seeder;

/**
 * Class AuthTableSeeder.
 */
class DummyClassPermissionTableSeeder extends Seeder
{
    use DisableForeignKeys;
    use SeederHelper;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();

        $this->seederPermission(DummyClass::permissions());

        $this->enableForeignKeys();
    }

}
