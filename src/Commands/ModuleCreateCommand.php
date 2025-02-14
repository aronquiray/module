<?php


namespace HalcyonLaravel\Module\Commands;

use HalcyonLaravel\Module\Commands\Traits\BackUpTraits;
use Illuminate\Container\Container;
use Illuminate\Support\Str;
use NunoMaduro\LaravelConsoleMenu\Menu;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ModuleCreateCommand
 *
 * @package HalcyonLaravel\Module\Commands
 * @method Menu menu(string $string, string[] $array)
 */
class ModuleCreateCommand extends ModuleGeneratorCommand
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
    protected $generatedFiles;

    public function handle()
    {
        $this->options = null;
        $this->generatedFiles = [];
        $this->line("<fg=yellow>Generating {$this->type} '".$this->getNameInput().'\' ...</>');

        $this->generate($this->getStub());


        $this->line('<fg=yellow>Generating "'.$this->getNameInput().'" '.$this->type.' backup files ...</>');
        $this->generatingFile($this->options);
        $this->line('<fg=green>Done Generating "'.$this->getNameInput().'" '.$this->type.' backup files ...</>');

        $this->info("Done Generating {$this->type} '".$this->getNameInput().'\'.');

        $this->call(
            'make:bindings',
            [
                'name' => Str::studly($this->getNameInput()).'\\'.Str::studly($this->getNameInput()),
            ]
        );

        if (app()->environment() != 'testing') {
            shell_exec('composer clear-all');
        }
    }

    protected function getStub()
    {
        $input = $this->getNameInput();
        $inputNamespace = $this->option('namespace');

        if (empty($input)) {
            $this->error('Aborted!, Please specify '.$this->type.' name.');
            exit();
        }

        if (!is_null($inputNamespace)) {
            if (!(preg_match("/[A-Z]/", $inputNamespace) === 0)) {
                $this->error('Aborted!, Try all lower case, then space for multiple words on namespace.');
                exit();
            }

            $this->namespace($inputNamespace);
        }

        if (!(preg_match("/[A-Z]/", $input) === 0)) {
            $this->error('Aborted!, Try all lower case, then space for multiple words on '.$this->type.' name.');
            exit();
        }

        $selected = $this->menu(
            'Generate for model "'.ucfirst(Str::studly($input)).'"'."\n".
            'What type of '.$this->type.' want to generate?',
            [
                'softdelete-history' => 'Softdelete and History',
                'history' => 'History',
                'softdelete' => 'Softdelete',
                'basic' => 'Just Basic, (none on the above)',
            ]
        )
            ->setForegroundColour('green')
            ->setBackgroundColour('black')
            ->setWidth(200)
            ->setPadding(10)
            ->setMargin(5)
            ->setExitButtonText("Abort")// remove exit button with ->disableDefaultItems()
//            ->setUnselectedMarker('*')
//            ->setSelectedMarker('->')
            // ->setTitleSeparator('*-')
            // ->addLineBreak('#', 1)
            // ->addStaticItem('AREA 2')
            ->open();

        $stubs = null;

        switch ($selected) {
            case 'softdelete-history':
                $this->options[] = 'softdelete';
                $this->options[] = 'history';
                $stubs = $this->basic_softdelete_history();
                break;
            case 'history':
                $this->options[] = 'history';
                $stubs = $this->basic_history();
                break;
            case 'softdelete':
                $this->options[] = 'softdelete';
                $stubs = $this->softdelete();
                break;
            case 'basic':
                // do nothing, just execute default
                break;
            case null:
                $this->error('Aborted ...');
                exit();
            default:
                $this->error('Argument not found, Aborted ...');
                exit();
        }

        return $stubs ?: $this->basic();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['namespace', null, InputOption::VALUE_OPTIONAL, 'Add Namespace.'],
            // ['history', null, InputOption::VALUE_NONE, 'With History.'],
        ];
    }

    protected function generate($modules)
    {
        foreach ($modules as $stub => $path) {
            $this->line("<fg=yellow>Generating $stub ...</>");

            $stub = $this->files->get(__DIR__.'/stubs/'.$stub);
            $stub = $this->_nameSpaceApp($stub);
            $stub = $this->_replaceName($stub);
            $stub = $this->_replacePath($stub);
            $path = $this->_replaceName($path);

            $path = $this->getStubByEnvironment($path);

            if ($this->files->exists($path, $stub)) {
                $this->error($this->type.' already exists!');
                exit();
            }

            $this->files->put($path, $stub);
            $this->line('<fg=green>Generated:</> '.$path);
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

        $path = $dir.$path;
        $this->makeDirectory($path);
        return $path;
    }

    private function _nameSpaceApp($stub)
    {
        return str_replace('DummyNameSpaceClass\\', $this->getAppNamespace(), $stub);
    }

    private function getAppNamespace()
    {
        return Container::getInstance()->getNamespace();
    }

    /**
     * Replace the name for the given stub.
     *
     * @param $stub
     *
     * @return mixed
     */
    private function _replaceName($stub)
    {
        $name = $this->getNameInput();
        // lloric code
        // Small case
        $stub = str_replace(
            'dummy classes',
            str_replace('-', ' ', Str::slug(Str::plural($name))),
            $stub
        ); // llorics | lloric codes
        $stub = str_replace(
            'dummy class',
            str_replace('-', ' ', Str::slug($name)),
            $stub
        ); // lloric | lloric code

        $stub = str_replace(
            'dummyclasses',
            str_replace('-', '', Str::slug(Str::plural($name))),
            $stub
        ); // llorics | lloriccodes
        $stub = str_replace(
            'dummyclass',
            str_replace('-', '', Str::slug($name)),
            $stub
        ); // lloric | lloriccode

        $stub = str_replace('dummy_classes', Str::snake(Str::plural($name)), $stub); // llorics | lloric_codes
        $stub = str_replace('dummy_class', Str::snake($name), $stub);                // lloric | lloric_code

        $stub = str_replace('dummy-classes', Str::slug(Str::plural($name)), $stub); // llorics | lloric-codes
        $stub = str_replace('dummy-class', Str::slug($name), $stub);                // lloric | lloric-code

        $stub = str_replace(
            'dummy.classes',
            str_replace('-', '.', Str::slug(Str::plural($name))),
            $stub
        ); // llorics | lloric.codes
        $stub = str_replace(
            'dummy.class',
            str_replace('-', '.', Str::slug($name)),
            $stub
        ); // lloric | lloric.code

        $stub = str_replace('dummyClasses', Str::camel(Str::plural($name)), $stub); // llorics | lloricCodes
        $stub = str_replace('dummyClass', Str::camel($name), $stub);                // lloric | lloricCode
        // Big Cases
        $stub = str_replace('Dummy Classes', ucwords(Str::plural($name)), $stub);   // Llorics | Lloric Codes
        $stub = str_replace(
            'Dummy Class',
            ucwords(str_replace('-', ' ', Str::slug($name))),
            $stub
        ); // Lloric | Lloric Code

        $stub = str_replace('DummyClasses', ucfirst(Str::studly(Str::plural($name))), $stub); // Llorics | LloricCodes
        $stub = str_replace('DummyClass', ucfirst(Str::studly($name)), $stub);                // Lloric | LloricCode
        return $stub;
    }

    private function _replacePath($stub)
    {
        $tmp = $this->option('namespace');
        if (is_null($tmp)) {
            $stub = str_replace('DummyPath\\', '', $stub);
            $stub = str_replace('dummy-path.', '', $stub);
            return str_replace('dummyPath.', '', $stub);
        }
        $stub = str_replace('DummyPath', ucfirst(Str::studly($tmp)), $stub);
        $stub = str_replace('dummy-path', Str::slug($tmp), $stub);
        return str_replace('dummyPath', Str::camel($tmp), $stub);
    }
}
