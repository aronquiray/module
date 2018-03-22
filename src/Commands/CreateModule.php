<?php


namespace HalcyonLaravel\Module\Commands;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class CreateModule extends GeneratorCommand
{
    /**
         * The console command name.
         *
         * @var string
         */
    protected $name = 'module:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make Module';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Module';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
    }

    public function handle()
    {
        $modules = null;
        $this->info('Module test');

    
        $modules = $modules ?: $this->basic();

        $this->generate($modules);
        $this->info('Module test done');
    }

    protected function basic()
    {
        // stub | direction path
        return [
            'basic/DummyClass.php' => 'app/Models/Core/DummyClass.php',
            'basic/DummyClassesController.php' => 'app/Http/Controllers/Backend/Core/DummyClass/DummyClassesController.php',

            // views
            'basic/resources/views/backend/create.blade.php' => 'resources/views/backend/dummyClass/create.blade.php',
            'basic/resources/views/backend/edit.blade.php' => 'resources/views/backend/dummyClass/edit.blade.php',
            'basic/resources/views/backend/index.blade.php' => 'resources/views/backend/dummyClass/index.blade.php',
            'basic/resources/views/backend/show.blade.php' => 'resources/views/backend/dummyClass/show.blade.php',
        ];
    }


    protected function generate($modules)
    {
        foreach ($modules as $stub => $path) {
            $stub = $this->files->get(__DIR__ . '/stubs/' . $stub);
            $stub = $this->replaceName($stub, $this->getNameInput());
            $path = $this->replaceName($path, $this->getNameInput());
            
            $this->makeDirectory($path);
            $this->files->put($path, $stub);
        }
    }

    /**
     * Replace the name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    public function replaceName($stub, $name)
    {
        // lloric code
        // Small case
        $stub = str_replace('dummy classes', str_replace('-', ' ', str_slug(str_plural($name))), $stub); // llorics | lloric codes
        $stub = str_replace('dummy class', str_replace('-', ' ', str_slug($name)), $stub); // lloric | lloric code

        $stub = str_replace('dummyclasses', str_replace('-', '', str_slug(str_plural($name))), $stub); // llorics | lloriccodes
        $stub = str_replace('dummyclass', str_replace('-', '', str_slug($name)), $stub); // lloric | lloriccode

        $stub = str_replace('dummy_classes', snake_case(str_plural($name)), $stub); // llorics | lloric_codes
        $stub = str_replace('dummy_class', snake_case($name), $stub); // lloric | lloric_code

        $stub = str_replace('dummy-classes', str_slug(str_plural($name)), $stub); // llorics | lloric-codes
        $stub = str_replace('dummy-class', str_slug($name), $stub); // lloric | lloric-code

        $stub = str_replace('dummy.classes', str_replace('-', '.', str_slug(str_plural($name))), $stub); // llorics | lloric.codes
        $stub = str_replace('dummy.class', str_replace('-', '.', str_slug($name)), $stub); // lloric | lloric.code

        $stub = str_replace('dummyClasses', camel_case(str_plural($name)), $stub); // llorics | lloricCodes
        $stub = str_replace('dummyClass', camel_case($name), $stub); // lloric | lloricCode
        // Big Cases
        $stub = str_replace('Dummy Classes', ucwords(str_plural($name)), $stub); // Llorics | Lloric Codes
        $stub = str_replace('Dummy Class', ucwords(str_replace('-', ' ', str_slug($name))), $stub); // Lloric | Lloric Code

        $stub = str_replace('DummyClasses', ucfirst(studly_case(str_plural($name))), $stub); // Llorics | LloricCodes
        $stub = str_replace('DummyClass', ucfirst(studly_case($name)), $stub); // Lloric | LloricCode
        return $stub;
    }


    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['softdelete', 'sd', InputOption::VALUE_OPTIONAL, 'With Softdeletes.'],

            // ['resource', 'r', InputOption::VALUE_NONE, 'Generate a resource controller class.'],

            // ['parent', 'p', InputOption::VALUE_OPTIONAL, 'Generate a nested resource controller class.'],

            // ['api', null, InputOption::VALUE_NONE, 'Exclude the create and edit methods from the controller.'],
        ];
    }
}
