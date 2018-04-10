<?php


namespace HalcyonLaravel\Module\Commands;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;
use HalcyonLaravel\Module\Commands\Traits\BackUpTraits;

class ModuleCreateCommand extends ModuleGeneratorCommad
{
    use BackUpTraits;
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


    protected $options;
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $stubs = null;

        if ($this->option('softdelete') && $this->option('history')) {
            $this->options[] = 'softdelete';
            $this->options[] = 'history';
            $stubs =   $this->basic_softdelete_history();
        } elseif (!$this->option('softdelete') && $this->option('history')) {
            $this->options[] = 'history';
            $stubs = $this->basic_history();
        } elseif ($this->option('softdelete')) {
            $this->options[] = 'softdelete';
            $stubs = $this->softdelete();
        }
        return $stubs ?: $this->basic();
    }

    public function handle()
    {
        $this->options = null;
        $this->generatedFiles = [];
        $this->line("<fg=yellow>Generating {$this->type} '" . $this->getNameInput() . '\' ...</>');

        $this->generate($this->getStub());


        $this->line('<fg=yellow>Generating "' . $this->getNameInput() . '" ' . $this->type . ' backup files ...</>');
        $this->generatingFile($this->options);
        $this->line('<fg=green>Done Generating "' . $this->getNameInput() . '" ' . $this->type . ' backup files ...</>');

        $this->info("Done Generating {$this->type} '" . $this->getNameInput() . '\'.');

        if (app()->environment() != 'testing') {
            shell_exec('composer clear-all');
        }
    }


    protected function generate($modules)
    {
        foreach ($modules as $stub => $path) {
            $this->line("<fg=yellow>Generating $stub ...</>");
            
            $stub = $this->files->get(__DIR__ .'/stubs/' . $stub);
            $stub = $this->replaceName($stub, $this->getNameInput());
            $path = $this->replaceName($path, $this->getNameInput());

            $path = $this->getStubByEnvironment($path);
            
            if ($this->files->exists($path, $stub)) {
                $this->error($this->type . ' already exists!');
                exit();
            }
            
            $this->files->put($path, $stub);
            $this->line('<fg=green>Generated:</> ' . $path);
        }
    }

    protected function getStubByEnvironment($path)
    {
        $dir = '';
        
        if (app()->environment() == 'testing') {
            $dir = 'tests/tmp/';
        } else {
            $this->generatedFiles[] = $this->removeProjectDir($path);
        }

        $path = $dir . $path;
        $this->makeDirectory($path);
        return $path;
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
            ['softdelete', null, InputOption::VALUE_NONE, 'With Softdeletes.'],
            ['history', null, InputOption::VALUE_NONE, 'With History.'],
        ];
    }
}
