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
            'softdelete/model.stub' => 'app/Models/DummyClass/DummyClass.php',

            // database
            'softdelete/database/migration.stub' => $this->_databaseMigrationFileName(),

            // test
            'softdelete/tests/backend-deletes.stub' => 'tests/Feature/Modules/Backend/DummyClass/DummyClassBreadFeatureDeletesBackendTest.php',

        ];

        // get only specific stubs in basic
        return array_merge($stubs, array_only($this->basic(), [
            // controllers
            'basic/controllers/resource.stub',
            'basic/controllers/frontend.stub',
            // repository
            'basic/repo.stub',
            // tests
            'basic/tests/backend.stub',
            'basic/tests/frontend.stub',
            // routes
            'basic/routes/frontend.stub',
            // database
            'basic/database/factory.stub',
            'basic/database/table-seeder.stub',
            'basic/database/permission-seeder.stub' ,
            // resources views backend
            'basic/resources/views/backend/create.stub',
            'basic/resources/views/backend/edit.stub',
            'basic/resources/views/backend/show.stub',
            // resources view backend partilas
            'basic/resources/views/backend/partials/fields.stub',
            'basic/resources/views/backend/partials/overview.stub',
            // resources view frontend
            'basic/resources/views/frontend/index.stub',
            'basic/resources/views/frontend/show.stub',
            'basic/resources/views/frontend/partials/node.stub',
            // model traits
            'basic/model-traits/attribute.stub',
            'basic/model-traits/regular.stub',
            'basic/model-traits/relation.stub',
            'basic/model-traits/scope.stub',
            'basic/model-traits/static.stub',
        ]));
    }

    protected function basic_history()
    {
        $stubs = $this->basic();

        foreach ([
            // repository
            'basic/model.stub',
            // repository
            'basic/repo.stub',
            // routes
            'basic/routes/backend.stub',
            'basic/routes/bread-crumbs.stub',
            // resources
            'basic/resources/views/backend/partials/links.stub',
        ] as $forget) {
            array_forget($stubs, $forget);
        }

        $hiostoryStubs = [
            // model
            'basic-history/model.stub' => 'app/Models/DummyClass/DummyClass.php',

            // repository replace
            'basic-history/repo.stub' => 'app/Repositories/Backend/DummyClass/DummyClassRepository.php',

            // controllers
            'basic-history/controllers/history.stub' => 'app/Http/Controllers/Backend/DummyClass/DummyClassesHistoryController.php',
            // 'basic-history/controllers/resource.stub' => 'app/Http/Controllers/Backend/DummyClass/DummyClassesController.php',

            // resources
            'basic-history/resources/views/backend/partials/links.stub' => 'resources/views/backend/dummyClass/partials/links.blade.php',
            'basic-history/resources/views/backend/history.stub' => 'resources/views/backend/dummyClass/history.blade.php',

            // routes
            'basic-history/routes/backend.stub' => 'routes/backend/dummy-class.php',
            'basic-history/routes/bread-crumbs.stub' => 'routes/breadcrumbs/backend/dummy-class.php',

            // tests
            'basic-history/tests/history.stub' => 'tests/Feature/Modules/Backend/DummyClass/DummyClassFeatureHistoryTest.php',
        ];

        return array_merge($stubs, $hiostoryStubs);
    }

    protected function basic_softdelete_history()
    {
        $softdeleteStubs = $this->softdelete();

        foreach ([
            // model
             'softdelete/model.stub' ,

            // repository
            'basic/repo.stub', // inherited from basic
            // controllers
            'basic/controllers/resource.stub', // inherited from basic
            // 'softdelete/controllers/deleted.stub',
            // routes
            'softdelete/routes/backend.stub',
            'softdelete/routes/bread-crumbs.stub',
            // resources
            'softdelete/resources/views/backend/partials/links.stub',
        ] as $forget) {
            array_forget($softdeleteStubs, $forget);
        }

        $additionalStubs = [
            // model
            'basic-softdelete-history/model.stub' => 'app/Models/DummyClass/DummyClass.php',

            // repository replace
            'basic-softdelete-history/repo.stub' => 'app/Repositories/Backend/DummyClass/DummyClassRepository.php',

            // controllers replace
            // 'basic-softdelete-history/controllers/resource.stub' =>  'app/Http/Controllers/Backend/DummyClass/DummyClassesController.php',
            // 'basic-softdelete-history/controllers/deleted.stub' => 'app/Http/Controllers/Backend/DummyClass/DummyClassesDeletedController.php',
          
            // routes
            'basic-softdelete-history/routes/backend.stub' => 'routes/backend/dummy-class.php',
            'basic-softdelete-history/routes/bread-crumbs.stub' => 'routes/breadcrumbs/backend/dummy-class.php',

            // resources replace
            'basic-softdelete-history/resources/views/backend/partials/links.stub' => 'resources/views/backend/dummyClass/partials/links.blade.php',
      ];

        return array_merge(array_merge($softdeleteStubs, $additionalStubs), array_only($this->basic_history(), [
            // controllers
            'basic-history/controllers/history.stub',
            
            'basic/controllers/resource.stub', // inherited

            // resources
            'basic-history/resources/views/backend/history.stub',

            // tests
            'basic-history/tests/history.stub',
        ]));
    }

    protected function basic()
    {
        // stub | direction path
        return [
            // Obserber 
            'basic/observer.stub' => 'app/Observers/DummyClassObserver.php',

            // repository
            'basic/repo.stub' => 'app/Repositories/Backend/DummyClass/DummyClassRepository.php',

            // controllers
            'basic/controllers/resource.stub' => 'app/Http/Controllers/Backend/DummyClass/DummyClassesController.php',
            'basic/controllers/frontend.stub' => 'app/Http/Controllers/Frontend/DummyClass/DummyClassesController.php',
            'basic/controllers/table.stub' => 'app/Http/Controllers/Backend/DummyClass/DummyClassesTableController.php',

            // views backend
            'basic/resources/views/backend/create.stub' => 'resources/views/backend/dummyClass/create.blade.php',
            'basic/resources/views/backend/edit.stub' => 'resources/views/backend/dummyClass/edit.blade.php',
            'basic/resources/views/backend/index.stub' => 'resources/views/backend/dummyClass/index.blade.php',
            'basic/resources/views/backend/show.stub' => 'resources/views/backend/dummyClass/show.blade.php',
            // views partials
            'basic/resources/views/backend/partials/links.stub' => 'resources/views/backend/dummyClass/partials/links.blade.php',
            'basic/resources/views/backend/partials/fields.stub' => 'resources/views/backend/dummyClass/partials/fields.blade.php',
            'basic/resources/views/backend/partials/overview.stub' => 'resources/views/backend/dummyClass/partials/overview.blade.php',

            // views frontend
            'basic/resources/views/frontend/index.stub' => 'resources/views/frontend/dummyClass/index.blade.php',
            'basic/resources/views/frontend/show.stub' => 'resources/views/frontend/dummyClass/show.blade.php',
            'basic/resources/views/frontend/partials/node.stub' => 'resources/views/frontend/dummyClass/partials/node.blade.php',
           
            // route
            'basic/routes/backend.stub' => 'routes/backend/dummy-class.php',
            'basic/routes/frontend.stub' => 'routes/frontend/dummy-class.php',
            'basic/routes/bread-crumbs.stub' => 'routes/breadcrumbs/backend/dummy-class.php',

            // model
            'basic/model.stub' => 'app/Models/DummyClass/DummyClass.php',
            // model traits
            'basic/model-traits/attribute.stub' => 'app/Models/DummyClass/Traits/DummyClassAttributes.php',
            'basic/model-traits/regular.stub' => 'app/Models/DummyClass/Traits/DummyClassRegularFunctions.php',
            'basic/model-traits/relation.stub' => 'app/Models/DummyClass/Traits/DummyClassRelations.php',
            'basic/model-traits/scope.stub' => 'app/Models/DummyClass/Traits/DummyClassScopes.php',
            'basic/model-traits/static.stub' => 'app/Models/DummyClass/Traits/DummyClassStaticFunctions.php',

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
