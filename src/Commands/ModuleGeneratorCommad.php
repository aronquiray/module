<?php


namespace HalcyonLaravel\Module\Commands;

use Illuminate\Console\GeneratorCommand;

abstract class ModuleGeneratorCommad extends GeneratorCommand
{
    private function _databaseMigrationFileName()
    {
        $migrationFileName = now()->format('Y_m_d_hms') . '_create_dummy_classes_table';
        return  "database/migrations/$migrationFileName.php";
    }

    protected function softdelete()
    {
        // stub | direction path
        $stubs = [
            // controllers
            'softdelete/controllers/table.stub' => 'app/Http/Controllers/Backend/DummyClass/DummyClassesTableController.php',
            'softdelete/controllers/deleted.stub' => 'app/Http/Controllers/Backend/DummyClass/DummyClassesDeletedController.php',

            // views
            'softdelete/resources/views/backend/index.stub' => 'resources/views/backend/dummyClass/index.blade.php',
            'softdelete/resources/views/backend/deleted.stub' => 'resources/views/backend/dummyClass/deleted.blade.php',
            // views partials
            'softdelete/resources/views/backend/partials/links.stub' => 'resources/views/backend/dummyClass/partials/links.blade.php',

            // route
            'softdelete/routes/backend.stub' => 'routes/backend/dummy-class.php',
            'softdelete/routes/bread-crumbs.stub' => 'routes/breadcrumbs/backend/dummy-class.php',

            // model
            'softdelete/model.stub' => 'app/Models/DummyClass.php',

            // database
            'softdelete/database/migration.stub' => $this->_databaseMigrationFileName(),

            // test
            'softdelete/tests/backend-deletes.stub' => 'tests/Feature/Modules/Backend/DummyClass/DummyClassBreadFeatureDeletesBackendTest.php',

        ];

        // get only specific stubs in basic
        return array_merge($stubs, array_only($this->basic(), [
            // controllers
            'basic/controllers/resource.stub',
            // tests
            'basic/tests/backend.stub',
            'basic/tests/frontend.stub',
            // routes
            'basic/routes/frontend.stub',
            // database
            'basic/database/factory.stub',
            'basic/database/table-seeder.stub',
            'basic/database/permission-seeder.stub' ,
            // resources views
            'basic/resources/views/backend/create.stub',
            'basic/resources/views/backend/edit.stub',
            'basic/resources/views/backend/show.stub',
            // resources view partilas
            'basic/resources/views/backend/partials/fields.stub',
            'basic/resources/views/backend/partials/overview.stub',
        ]));
    }

    protected function basic_history()
    {
        $stubs = $this->basic();

        foreach([
            // controllers
            'basic/controllers/resource.stub',
            // routes
            'basic/routes/backend.stub',
            'basic/routes/bread-crumbs.stub',
            // resources
            'basic/resources/views/backend/partials/links.stub',
        ] as $forget)
        {
            array_forget($stubs, $forget);
        }

        $hiostoryStubs = [
            // controllers
            'basic-history/controllers/history.stub' => 'app/Http/Controllers/Backend/DummyClass/DummyClassesHistoryController.php',
            'basic-history/controllers/resource.stub' => 'app/Http/Controllers/Backend/DummyClass/DummyClassesController.php',

            // resources
            'basic-history/resources/views/backend/partials/links.stub' => 'resources/views/backend/dummyClass/partials/links.blade.php',
            'basic-history/resources/views/backend/history.stub' => 'resources/views/backend/dummyClass/history.blade.php',

            // routes
            'basic-history/routes/backend.stub' => 'routes/backend/dummy-class.php',
            'basic-history/routes/bread-crumbs.stub' => 'routes/breadcrumbs/backend/dummy-class.php',
        ];

        return array_merge($stubs, $hiostoryStubs);
    }

    protected function basic_softdelete_history()
    {
        $stubs = $this->softdelete();

        foreach([
            // controllers
            'basic/controllers/resource.stub', // inherited from basic
            'softdelete/controllers/deleted.stub',
            // routes
            'softdelete/routes/backend.stub',
            'softdelete/routes/bread-crumbs.stub',
            // resources
            'softdelete/resources/views/backend/partials/links.stub',
        ] as $forget)
        {
            array_forget($stubs, $forget);
        }

        // controllers replace
        $stubs['basic-softdelete-history/controllers/resource.stub'] =  'app/Http/Controllers/Backend/DummyClass/DummyClassesController.php';
        $stubs['basic-softdelete-history/controllers/deleted.stub'] = 'app/Http/Controllers/Backend/DummyClass/DummyClassesDeletedController.php';
        // controllers
        $stubs['basic-softdelete-history/controllers/history.stub'] =  'app/Http/Controllers/Backend/DummyClass/DummyClassesHistoryController.php';

        // routes
        $stubs['basic-softdelete-history/routes/backend.stub'] = 'routes/backend/dummy-class.php';
        $stubs['basic-softdelete-history/routes/bread-crumbs.stub'] = 'routes/breadcrumbs/backend/dummy-class.php';

        // resources replace
        $stubs['basic-softdelete-history/resources/views/backend/partials/links.stub'] = 'resources/views/backend/dummyClass/partials/links.blade.php';
        // resources 
        $stubs['basic-softdelete-history/resources/views/backend/history.stub'] = 'resources/views/backend/dummyClass/history.blade.php';

        return $stubs;
    }

    protected function basic()
    {
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
            'basic/resources/views/backend/partials/links.stub' => 'resources/views/backend/dummyClass/partials/links.blade.php',
            'basic/resources/views/backend/partials/fields.stub' => 'resources/views/backend/dummyClass/partials/fields.blade.php',
            'basic/resources/views/backend/partials/overview.stub' => 'resources/views/backend/dummyClass/partials/overview.blade.php',

            // route
            'basic/routes/backend.stub' => 'routes/backend/dummy-class.php',
            'basic/routes/frontend.stub' => 'routes/frontend/dummy-class.php',
            'basic/routes/bread-crumbs.stub' => 'routes/breadcrumbs/backend/dummy-class.php',

            // model
            'basic/model.stub' => 'app/Models/DummyClass.php',

            // database
            'basic/database/migration.stub' => $this->_databaseMigrationFileName(),
            'basic/database/factory.stub' => "database/factories/DummyClassFactory.php",
            'basic/database/table-seeder.stub' => "database/seeds/Modules/DummyClassTableSeeder.php",
            'basic/database/permission-seeder.stub' => "database/seeds/Modules/Permissions/DummyClassPermissionTableSeeder.php",

            // tests
            'basic/tests/backend-deletes.stub' => 'tests/Feature/Modules/Backend/DummyClass/DummyClassBreadFeatureDeletesBackendTest.php',
            'basic/tests/backend.stub' => 'tests/Feature/Modules/Backend/DummyClass/DummyClassBreadFeatureBackendTest.php',
            'basic/tests/frontend.stub' => 'tests/Feature/Modules/Frontend/DummyClass/DummyClassFeatureFrontendTest.php',
        ];
    }
}
