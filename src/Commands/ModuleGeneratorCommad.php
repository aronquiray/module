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
            'softdelete/controllers/resource.stub' => 'app/Http/Controllers/Backend/DummyClass/DummyClassesController.php',
            'softdelete/controllers/table.stub' => 'app/Http/Controllers/Backend/DummyClass/DummyClassesTableController.php',
            'softdelete/controllers/deleted.stub' => 'app/Http/Controllers/Backend/DummyClass/DummyClassesDeletedController.php',

            // views
            'softdelete/resources/views/backend/create.stub' => 'resources/views/backend/dummyClass/create.blade.php',
            'softdelete/resources/views/backend/edit.stub' => 'resources/views/backend/dummyClass/edit.blade.php',
            'softdelete/resources/views/backend/index.stub' => 'resources/views/backend/dummyClass/index.blade.php',
            'softdelete/resources/views/backend/show.stub' => 'resources/views/backend/dummyClass/show.blade.php',
            'softdelete/resources/views/backend/deleted.stub' => 'resources/views/backend/dummyClass/deleted.blade.php',
            // views partials
            'softdelete/resources/views/backend/partials/fields.stub' => 'resources/views/backend/dummyClass/partials/fields.blade.php',
            'softdelete/resources/views/backend/partials/overview.stub' => 'resources/views/backend/dummyClass/partials/overview.blade.php',
            'softdelete/resources/views/backend/partials/links.stub' => 'resources/views/backend/dummyClass/partials/links.blade.php',

            // route
            'softdelete/routes/backend.stub' => 'routes/backend/dummy-class.php',
            'softdelete/routes/bread-crumbs.stub' => 'routes/breadcrumbs/backend/dummy-class.php',

            // model
            'softdelete/model.stub' => 'app/Models/DummyClass.php',

            // database
            'softdelete/database/migration.stub' => "database/migrations/$migrationFileName.php",
            'softdelete/database/factory.stub' => "database/factories/DummyClassFactory.php",
            'softdelete/database/table-seeder.stub' => "database/seeds/Modules/DummyClassTableSeeder.php",
            'softdelete/database/permission-seeder.stub' => "database/seeds/Modules/Permissions/DummyClassPermissionTableSeeder.php",

            // tests
            'softdelete/tests/test.stub' => 'tests/Feature/Module/Backend/DummyClassBreadFeatureTest.php',
        ];
    }

    protected function basic_softdelete_history()
    {
        // get the softdelete
        $stubs = $this->softdelete();

        // replace stubs that has softdelete and history
        // unset
        unset(
            $stubs['softdelete/resource-controller.stub'],
            $stubs['softdelete/backend-route.stub'],
            $stubs['softdelete/resources/views/backend/partials/links.stub'],
            $stubs['softdelete/bread-crumbs.stub'],
            $stubs['softdelete/deleted-controller.stub']
        );
        $stubs['basic-softdelete-history/controllers/resource.stub'] =  'app/Http/Controllers/Backend/DummyClass/DummyClassesController.php';
        $stubs['basic-softdelete-history/routes/backend.stub'] = 'routes/backend/dummy-class.php';
        $stubs['basic-softdelete-history/resources/views/backend/partials/links.stub'] = 'resources/views/backend/dummyClass/partials/links.blade.php';
        $stubs['basic-softdelete-history/routes/bread-crumbs.stub'] = 'routes/breadcrumbs/backend/dummy-class.php';
        $stubs['basic-softdelete-history/controllers/deleted.stub'] = 'app/Http/Controllers/Backend/DummyClass/DummyClassesDeletedController.php';

        /**
         * addtional
         */
        // controller
        $stubs['basic-softdelete-history/controllers/history.stub'] =  'app/Http/Controllers/Backend/DummyClass/DummyClassesHistoryController.php';
        // view
        $stubs['basic-softdelete-history/resources/views/backend/history.stub'] =  'resources/views/backend/dummyClass/history.blade.php';

        return $stubs;
    }

    protected function basic()
    {
        $migrationFileName = now()->format('Y_m_d_hms') . '_create_dummy_classes_table';
        // stub | direction path
        return [
            // controllers
            'basic/controllers/resource.stub' => 'app/Http/Controllers/Backend/DummyClass/DummyClassesController.php',
            'basic/controllers/table.stub' => 'app/Http/Controllers/Backend/DummyClass/DummyClassesTableController.php',

            // views
            'basic/resources/views/backend/create.stub' => 'resources/views/backend/dummyClass/create.blade.php',
            'basic/resources/views/backend/edit.stub' => 'resources/views/backend/dummyClass/edit.blade.php',
            'basic/resources/views/backend/index.stub' => 'resources/views/backend/dummyClass/index.blade.php',
            'basic/resources/views/backend/show.stub' => 'resources/views/backend/dummyClass/show.blade.php',
            // views partials
            'basic/resources/views/backend/partials/fields.stub' => 'resources/views/backend/dummyClass/partials/fields.blade.php',
            'basic/resources/views/backend/partials/overview.stub' => 'resources/views/backend/dummyClass/partials/overview.blade.php',

            // route
            'basic/routes/backend.stub' => 'routes/backend/dummy-class.php',
            'basic/routes/frontend.stub' => 'routes/frontend/dummy-class.php',
            'basic/routes/bread-crumbs.stub' => 'routes/breadcrumbs/backend/dummy-class.php',

            // model
            'basic/model.stub' => 'app/Models/DummyClass.php',

            // database
            'basic/database/migration.stub' => "database/migrations/$migrationFileName.php",
            'basic/database/factory.stub' => "database/factories/DummyClassFactory.php",
            'basic/database/table-seeder.stub' => "database/seeds/Modules/DummyClassTableSeeder.php",
            'basic/database/permission-seeder.stub' => "database/seeds/Modules/Permissions/DummyClassPermissionTableSeeder.php",

            // tests
            'basic/tests/test.stub' => 'tests/Feature/Module/Backend/DummyClassBreadFeatureTest.php',
        ];
    }
}
