<?php

namespace HalcyonLaravel\Module\Commands;

use HalcyonLaravel\Module\Commands\Traits\BackUpTraits;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;

// use Symfony\Component\Console\Input\InputOption;

class ModuleStatusCommand extends GeneratorCommand
{
    use BackUpTraits;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'module:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'See Modules status.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Module';


    public function handle()
    {
        if ($this->getNameInput() != '') {
            $module = $this->getBackupFile($this->getNameInput());

            if (is_null($module)) {
                $this->error("{$this->type} '{$this->getNameInput()}' not exist!");
                return;
            }

            $this->_tableFiles($module->datas);
        } else {
            $this->_tableAll($this->getBackupFile());
        }
    }

    protected function getStub()
    {
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::OPTIONAL, 'Module name.'],
        ];
    }

    private function _tableFiles($module)
    {
        $datas = [];
        $inc = 1;

        foreach ($module as $file) {
            $datas[] = [
                $inc++,
                $file,
            ];
        }

        $this->table(
            [
                '#',
                'File',
            ],
            $datas
        );
    }

    private function _tableAll($modules)
    {
        $header = [
            'Module Name',
            'Type',
            'Status',
            'File Count',
            'created at',
            'updated at',
            'deleted at',
        ];
        $datas = [];

        foreach ($modules as $module => $value) {
            $countFile = count($value->datas);
            $datas[] = [
                $module,
                implode(',', $value->types),
                $value->status,
                $countFile,
                $value->created_at,
                $value->updated_at,
                (is_null($value->deleted_at)) ? 'null' : $value->deleted_at,
            ];
        }

        $this->table($header, $datas);
    }
}
