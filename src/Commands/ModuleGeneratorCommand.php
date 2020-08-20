<?php


namespace HalcyonLaravel\Module\Commands;

use Illuminate\Console\GeneratorCommand;

abstract class ModuleGeneratorCommand extends GeneratorCommand
{

    private $_namespaceCapslock = '';
    private $_namespaceLower = '';

    public function namespace(string $inputNamespace)
    {
        $this->_namespaceCapslock = ucfirst(studly_case($inputNamespace)).'/';
        $this->_namespaceLower = camel_case($inputNamespace).'/';
    }

    protected function basic_softdelete_history()
    {
        $softdeleteStubs = $this->softdelete();

        foreach (
            [
                // model
                'softdelete/model.stub',

                // repository
                'basic/repo.stub',                 // inherited from basic
                // observer
                'basic/observer.stub',             // inherited from basic
                // controllers
                'basic/controllers/resource.stub', // inherited from basic
                // 'softdelete/controllers/deleted.stub',
                // routes
                'softdelete/routes/backend.stub',
                'softdelete/routes/bread-crumbs.stub',
                // resources
                'softdelete/resources/views/backend/partials/links.stub',
            ] as $forget
        ) {
            array_forget($softdeleteStubs, $forget);
        }

        $additionalStubs = [
            // model
            'basic-softdelete-history/model.stub' => 'app/Models/'.$this->_namespaceCapslock.'DummyClass/DummyClass.php',

            // repository replace
            'basic-softdelete-history/repo.stub' => 'app/Repositories/'.$this->_namespaceCapslock.'DummyClass/DummyClassRepositoryEloquent.php',

            // observer replace
            'basic-softdelete-history/observer.stub' => 'app/Repositories/'.$this->_namespaceCapslock.'DummyClass/DummyClassObserver.php',

            // controllers replace
            // 'basic-softdelete-history/controllers/resource.stub' =>  'app/Http/Controllers/Backend/' . $this->_namespaceCapslock  . 'DummyClass/DummyClassesController.php',
            // 'basic-softdelete-history/controllers/deleted.stub' => 'app/Http/Controllers/Backend/' . $this->_namespaceCapslock  . 'DummyClass/DummyClassesDeletedController.php',

            // routes
            'basic-softdelete-history/routes/backend.stub' => 'routes/backend/'.$this->_namespaceLower.'dummy-class.php',
            'basic-softdelete-history/routes/bread-crumbs.stub' => 'routes/breadcrumbs/backend/'.$this->_namespaceLower.'dummy-class.php',

            // resources replace
            'basic-softdelete-history/resources/views/backend/partials/links.stub' => 'resources/views/backend/'.$this->_namespaceLower.'dummyClass/partials/links.blade.php',
        ];

        return array_merge(
            array_merge($softdeleteStubs, $additionalStubs),
            array_only(
                $this->basic_history(),
                [
                    // controllers
                    'basic-history/controllers/history.stub',

                    'basic/controllers/resource.stub', // inherited

                    // resources
//            'basic-history/resources/views/backend/history.stub',

                    // tests
                    'basic-history/tests/history.stub',
                ]
            )
        );
    }

    protected function softdelete()
    {
        // stub | direction path
        $stubs = [
            // controllers
            'softdelete/controllers/table.stub' => 'app/Http/Controllers/Backend/'.$this->_namespaceCapslock.'DummyClass/DummyClassTableController.php',
            'softdelete/controllers/deleted.stub' => 'app/Http/Controllers/Backend/'.$this->_namespaceCapslock.'DummyClass/DummyClassDeletedController.php',

            // views
            'softdelete/resources/views/backend/index.stub' => 'resources/views/backend/'.$this->_namespaceLower.'dummyClass/index.blade.php',
            'softdelete/resources/views/backend/deleted.stub' => 'resources/views/backend/'.$this->_namespaceLower.'dummyClass/deleted.blade.php',
            // views partials
            'softdelete/resources/views/backend/partials/links.stub' => 'resources/views/backend/'.$this->_namespaceLower.'dummyClass/partials/links.blade.php',

            // route
            'softdelete/routes/backend.stub' => 'routes/backend/'.$this->_namespaceLower.'dummy-class.php',
            'softdelete/routes/bread-crumbs.stub' => 'routes/breadcrumbs/backend/'.$this->_namespaceLower.'dummy-class.php',

            // model
            'softdelete/model.stub' => 'app/Models/'.$this->_namespaceCapslock.'DummyClass/DummyClass.php',

            // database
            'softdelete/database/migration.stub' => $this->_databaseMigrationFileName(),

            // test
            'softdelete/tests/backend-deletes.stub' => 'tests/Feature/Modules/Backend/'.$this->_namespaceCapslock.'DummyClass/DummyClassBreadFeatureDeletesBackendTest.php',

        ];

        // get only specific stubs in basic
        return array_merge(
            $stubs,
            array_only(
                $this->basic(),
                [
                    // controllers
                    'basic/controllers/resource.stub',
                    'basic/controllers/frontend.stub',
                    // repository
                    'basic/repo.stub',
                    'basic/repo-interface.stub',
                    // observer
                    'basic/observer.stub',
                    // tests
                    'basic/tests/backend.stub',
                    'basic/tests/frontend.stub',
                    // routes
                    'basic/routes/frontend.stub',
                    // database
                    'basic/database/factory.stub',
                    'basic/database/table-seeder.stub',
                    'basic/database/permission-seeder.stub',
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
                ]
            )
        );
    }

    protected function basic()
    {
        // stub | direction path
        return [
            // Observer
            'basic/observer.stub' => 'app/Repositories/'.$this->_namespaceCapslock.'DummyClass/DummyClassObserver.php',
            // repository
            'basic/repo.stub' => 'app/Repositories/'.$this->_namespaceCapslock.'DummyClass/DummyClassRepositoryEloquent.php',
            'basic/repo-interface.stub' => 'app/Repositories/'.$this->_namespaceCapslock.'DummyClass/DummyClassRepository.php',

            // controllers
            'basic/controllers/resource.stub' => 'app/Http/Controllers/Backend/'.$this->_namespaceCapslock.'DummyClass/DummyClassController.php',
            'basic/controllers/frontend.stub' => 'app/Http/Controllers/Frontend/'.$this->_namespaceCapslock.'DummyClass/DummyClassController.php',
            'basic/controllers/table.stub' => 'app/Http/Controllers/Backend/'.$this->_namespaceCapslock.'DummyClass/DummyClassTableController.php',

            // views backend
            'basic/resources/views/backend/create.stub' => 'resources/views/backend/'.$this->_namespaceLower.'dummyClass/create.blade.php',
            'basic/resources/views/backend/edit.stub' => 'resources/views/backend/'.$this->_namespaceLower.'dummyClass/edit.blade.php',
            'basic/resources/views/backend/index.stub' => 'resources/views/backend/'.$this->_namespaceLower.'dummyClass/index.blade.php',
            'basic/resources/views/backend/show.stub' => 'resources/views/backend/'.$this->_namespaceLower.'dummyClass/show.blade.php',
            // views partials
            'basic/resources/views/backend/partials/links.stub' => 'resources/views/backend/'.$this->_namespaceLower.'dummyClass/partials/links.blade.php',
            'basic/resources/views/backend/partials/fields.stub' => 'resources/views/backend/'.$this->_namespaceLower.'dummyClass/partials/fields.blade.php',
            'basic/resources/views/backend/partials/overview.stub' => 'resources/views/backend/'.$this->_namespaceLower.'dummyClass/partials/overview.blade.php',

            // views frontend
            'basic/resources/views/frontend/index.stub' => 'resources/views/frontend/'.$this->_namespaceLower.'dummyClass/index.blade.php',
            'basic/resources/views/frontend/show.stub' => 'resources/views/frontend/'.$this->_namespaceLower.'dummyClass/show.blade.php',
            'basic/resources/views/frontend/partials/node.stub' => 'resources/views/frontend/'.$this->_namespaceLower.'dummyClass/partials/node.blade.php',

            // route
            'basic/routes/backend.stub' => 'routes/backend/'.$this->_namespaceLower.'dummy-class.php',
            'basic/routes/frontend.stub' => 'routes/frontend/'.$this->_namespaceLower.'dummy-class.php',
            'basic/routes/bread-crumbs.stub' => 'routes/breadcrumbs/backend/'.$this->_namespaceLower.'dummy-class.php',

            // model
            'basic/model.stub' => 'app/Models/'.$this->_namespaceCapslock.'DummyClass/DummyClass.php',
            // model traits
            'basic/model-traits/attribute.stub' => 'app/Models/'.$this->_namespaceCapslock.'DummyClass/Traits/DummyClassAttributes.php',
            'basic/model-traits/regular.stub' => 'app/Models/'.$this->_namespaceCapslock.'DummyClass/Traits/DummyClassRegularFunctions.php',
            'basic/model-traits/relation.stub' => 'app/Models/'.$this->_namespaceCapslock.'DummyClass/Traits/DummyClassRelations.php',
            'basic/model-traits/scope.stub' => 'app/Models/'.$this->_namespaceCapslock.'DummyClass/Traits/DummyClassScopes.php',
            'basic/model-traits/static.stub' => 'app/Models/'.$this->_namespaceCapslock.'DummyClass/Traits/DummyClassStaticFunctions.php',

            // database
            'basic/database/migration.stub' => $this->_databaseMigrationFileName(),
            'basic/database/factory.stub' => 'database/factories/'.$this->_namespaceCapslock.'dummy-class-factory.php',
            'basic/database/table-seeder.stub' => 'database/seeds/modules/'.$this->_namespaceCapslock.'DummyClassTableSeeder.php',
            'basic/database/permission-seeder.stub' => 'database/seeds/modules/Permissions/'.$this->_namespaceCapslock.'DummyClassPermissionTableSeeder.php',

            // tests
            'basic/tests/backend-deletes.stub' => 'tests/Feature/Modules/Backend/'.$this->_namespaceCapslock.'DummyClass/DummyClassBreadFeatureDeletesBackendTest.php',
            'basic/tests/backend.stub' => 'tests/Feature/Modules/Backend/'.$this->_namespaceCapslock.'DummyClass/DummyClassBreadFeatureBackendTest.php',
            'basic/tests/frontend.stub' => 'tests/Feature/Modules/Frontend/'.$this->_namespaceCapslock.'DummyClass/DummyClassFeatureFrontendTest.php',
        ];
    }

    protected function basic_history()
    {
        $stubs = $this->basic();

        foreach (
            [
                // repository
                'basic/model.stub',
                // repository
                'basic/repo.stub',
                // observer
                'basic/observer.stub',
                // routes
                'basic/routes/backend.stub',
                'basic/routes/bread-crumbs.stub',
                // resources
                'basic/resources/views/backend/partials/links.stub',
            ] as $forget
        ) {
            array_forget($stubs, $forget);
        }

        $hiostoryStubs = [
            // model
            'basic-history/model.stub' => 'app/Models/'.$this->_namespaceCapslock.'DummyClass/DummyClass.php',

            // Observer
            'basic-history/observer.stub' => 'app/Repositories/'.$this->_namespaceCapslock.'DummyClass/DummyClassObserver.php',
            // repository replace
            'basic-history/repo.stub' => 'app/Repositories/'.$this->_namespaceCapslock.'DummyClass/DummyClassRepositoryEloquent.php',

            // controllers
            'basic-history/controllers/history.stub' => 'app/Http/Controllers/Backend/'.$this->_namespaceCapslock.'DummyClass/DummyClassHistoryController.php',
            // 'basic-history/controllers/resource.stub' => 'app/Http/Controllers/Backend/' . $this->_namespaceCapslock  . 'DummyClass/DummyClassesController.php',

            // resources
            'basic-history/resources/views/backend/partials/links.stub' => 'resources/views/backend/'.$this->_namespaceLower.'dummyClass/partials/links.blade.php',
//            'basic-history/resources/views/backend/history.stub' => 'resources/views/backend/' . $this->_namespaceLower . 'dummyClass/history.blade.php',

            // routes
            'basic-history/routes/backend.stub' => 'routes/backend/'.$this->_namespaceLower.'dummy-class.php',
            'basic-history/routes/bread-crumbs.stub' => 'routes/breadcrumbs/backend/'.$this->_namespaceLower.'dummy-class.php',

            // tests
            'basic-history/tests/history.stub' => 'tests/Feature/Modules/Backend/'.$this->_namespaceCapslock.'DummyClass/DummyClassFeatureHistoryTest.php',
        ];

        return array_merge($stubs, $hiostoryStubs);
    }

    private function _databaseMigrationFileName()
    {
        $migrationFileName = now()->format('Y_m_d_hms').'_create_dummy_classes_table';
        return "database/migrations/$migrationFileName.php";
    }
}
