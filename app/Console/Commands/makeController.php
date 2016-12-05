<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;

class makeController extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:controller {name} {--template=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate CRUD';

    protected $type = 'Controller admin';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        parent::fire();
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Controllers';
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace('DummyClass', $class, $stub);
    }

    protected function buildClass($name)
    {
        $namespace = $this->getNamespace($name);

        return str_replace("use {$namespace}\Controller;\n", '', parent::buildClass($name));
    }

    public function getStub()
    {
        if ($this->option('template') == 'admin') {
            return __DIR__.'/crud/controller/controller.admin.stub';
        }

        return __DIR__.'/crud/controller/controller.plain.stub';
    }
}