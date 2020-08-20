<?php

namespace HalcyonLaravel\Module\Commands;

use HalcyonLaravel\Module\Commands\Traits\BackUpTraits;
use Illuminate\Console\GeneratorCommand;

class ModuleDeleteCommand extends GeneratorCommand
{
    use BackUpTraits;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'module:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete generated Module.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Module';

    /**
     * Execute the console command.
     *
     * @return bool|void|null
     */
    public function handle()
    {
        $datas = $this->getBackupFile($this->getNameInput());

        if (is_null($datas)) {
            $this->error("{$this->type} '{$this->getNameInput()}' not exist");
            return;
        } elseif ($datas->status == 'inactive') {
            $this->error("{$this->type} '{$this->getNameInput()}' already deleted at {$datas->deleted_at}");
            return;
        }


        $this->_deletingFiles($datas->datas);

        $this->line("".'<bg=green>Module "'.$this->getNameInput().'" deleted successfully.</>');

        shell_exec('composer clear-all');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->currentStub;
    }

    private function _deletingFiles($datas)
    {
        foreach ($datas as $file) {
            $file = $this->addProjectDir($file);
            $this->line('<fg=yellow>Deleting:</>      '.$file);
            $this->files->delete($file);
            $this->line('<fg=green>Done Deleting:</> '.$file);
        }

        $this->udpateDeleteData($this->getNameInput());
    }

    private function _checkFile()
    {
        $this->line("checking {$this->type} '{$this->_getCamelCaseModuleInput()}' ...");
    }

    private function _getCamelCaseModuleInput()
    {
        return camel_case($this->getNameInput());
    }
}
