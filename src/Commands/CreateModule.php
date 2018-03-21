<?php


namespace HalcyonLaravel\Module\Commands;

use Illuminate\Console\Command;

class CreateModule extends Command
{
    protected $signature = 'module:make'; 
                // {name : The name of the permission} 
                // {guard? : The name of the guard}';
    
    protected $description = 'Make a module';

    public function handle()
    {            
        $this->info("Module test");
    }
}
