<?php


namespace HalcyonLaravel\Module\Commands;

use Illuminate\Console\GeneratorCommand;

abstract class ModuleGeneratorCommad extends GeneratorCommand
{
    protected function softdelete()
    {
        $migrationFileName = now()->format('Y_m_d_hms') . '_create_dummy_classes_table';
        // stub | direction path
        return [
            // controllers
            'softdelete/resource-controller.stub' => 'app/Http/Controllers/Backend/Core/DummyClass/DummyClassesController.php',
            'softdelete/table-controller.stub' => 'app/Http/Controllers/Backend/Core/DummyClass/DummyClassesTableController.php',
            'softdelete/deleted-controller.stub' => 'app/Http/Controllers/Backend/Core/DummyClass/DummyClassesDeleteController.php',

            // views
            'softdelete/resources/views/backend/create.stub' => 'resources/views/backend/core/dummyClass/create.blade.php',
            'softdelete/resources/views/backend/edit.stub' => 'resources/views/backend/core/dummyClass/edit.blade.php',
            'softdelete/resources/views/backend/index.stub' => 'resources/views/backend/core/dummyClass/index.blade.php',
            'softdelete/resources/views/backend/show.stub' => 'resources/views/backend/core/dummyClass/show.blade.php',
            // views partials
            'softdelete/resources/views/backend/partials/fields.stub' => 'resources/views/backend/core/dummyClass/partials/fields.blade.php',
            'softdelete/resources/views/backend/partials/overview.stub' => 'resources/views/backend/core/dummyClass/partials/overview.blade.php',

            // route
            'softdelete/backend-route.stub' => 'routes/backend/core/dummy-class.php',
            'softdelete/bread-crumbs.stub' => 'routes/breadcrumbs/backend/core/dummy-class.php',

            // model
            'softdelete/model.stub' => 'app/Models/Core/DummyClass.php',

            // database
            'softdelete/database/migration.stub' => "database/migrations/$migrationFileName.php",
            'softdelete/database/factory.stub' => "database/factories/core/DummyClassFactory.php",
            'softdelete/database/table-seeder.stub' => "database/seeds/Modules/Core/DummyClassTableSeeder.php",
            'softdelete/database/permission-seeder.stub' => "database/seeds/Modules/Core/Permissions/DummyClassPermissionTableSeeder.php",

            // tests
            'softdelete/tests/test.stub' => 'tests/Feature/Module/Backend/DummyClassBreadFeatureTest.php',
        ];
    }

    protected function basic()
    {
        $migrationFileName = now()->format('Y_m_d_hms') . '_create_dummy_classes_table';
        // stub | direction path
        return [
            // controllers
            'basic/resource-controller.stub' => 'app/Http/Controllers/Backend/Core/DummyClass/DummyClassesController.php',
            'basic/table-controller.stub' => 'app/Http/Controllers/Backend/Core/DummyClass/DummyClassesTableController.php',

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

            // database
            'basic/database/migration.stub' => "database/migrations/$migrationFileName.php",
            'basic/database/factory.stub' => "database/factories/core/DummyClassFactory.php",
            'basic/database/table-seeder.stub' => "database/seeds/Modules/Core/DummyClassTableSeeder.php",
            'basic/database/permission-seeder.stub' => "database/seeds/Modules/Core/Permissions/DummyClassPermissionTableSeeder.php",

            // tests
            'basic/tests/test.stub' => 'tests/Feature/Module/Backend/DummyClassBreadFeatureTest.php',
        ];
    }
}
