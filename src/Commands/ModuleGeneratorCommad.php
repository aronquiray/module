<?php


namespace HalcyonLaravel\Module\Commands;

use Illuminate\Console\GeneratorCommand;

abstract class ModuleGeneratorCommad extends GeneratorCommand
{
    protected function basic()
    {
        $migrationFileName = now()->format('Y_m_d_hms') . '_create_dummy_classes_table';
        // stub | direction path
        return [
            // controllers
            'basic/DummyClassesController.stub' => 'app/Http/Controllers/Backend/Core/DummyClass/DummyClassesController.php',
            'basic/DummyClassesTableController.stub' => 'app/Http/Controllers/Backend/Core/DummyClass/DummyClassesTableController.php',

            // views
            'basic/resources/views/backend/create.stub' => 'resources/views/backend/core/dummyClass/create.blade.php',
            'basic/resources/views/backend/edit.stub' => 'resources/views/backend/core/dummyClass/edit.blade.php',
            'basic/resources/views/backend/index.stub' => 'resources/views/backend/core/dummyClass/index.blade.php',
            'basic/resources/views/backend/show.stub' => 'resources/views/backend/core/dummyClass/show.blade.php',
            // views partials
            'basic/resources/views/backend/partials/fields.stub' => 'resources/views/backend/core/dummyClass/partials/fields.blade.php',
            'basic/resources/views/backend/partials/overview.stub' => 'resources/views/backend/core/dummyClass/partials/overview.blade.php',

            // route
            'basic/backend-route.stub' => 'routes/backend/core/dummy-class.php',
            'basic/bread-crumbs.stub' => 'routes/breadcrumbs/backend/core/dummy-class.php',

            // model
            'basic/model.stub' => 'app/Models/Core/DummyClass.php',

            // migration
            'basic/database/migration.stub' => "database/migrations/$migrationFileName.php",
            'basic/database/factory.stub' => "database/factories/core/DummyClassFactory.php",
            'basic/database/tableSeeder.stub' => "database/seeds/Modules/Core/DummyClassTableSeeder.php",
            'basic/database/permissionSeeder.stub' => "database/seeds/Modules/Core/Permissions/DummyClassPermissionTableSeeder.php",

            // tests
            'basic/tests/test.stub' => 'tests/Feature/Module/Backend/DummyClassBreadFeatureTest.php',
        ];
    }
}
