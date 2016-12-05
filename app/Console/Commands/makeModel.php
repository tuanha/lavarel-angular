<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Schema;

class makeModel extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:model {name} {--template=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate CRUD';

    protected $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        parent::fire();
    }

    protected function getPath($name){
        $name = str_replace_first($this->laravel->getNamespace(), '', $name);
        return $this->laravel['path'].'/'.str_replace('\\', '/', studly_case(str_singular($name))).'.php';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }

    protected function replaceClass($stub, $name)
    {
        $class = str_replace($this->getNamespace($name).'\\', '', $name);
        return str_replace('DummyClass', studly_case(str_singular($class)), $stub);
    }

    protected function buildClass($name)
    {
        $table = str_plural(strtolower($this->getNameInput($name)));

        if( $this->checkTableExists($table) ) {
            $namespace  = $this->getNamespace($name);
            $columns    = $this->getTableStruct($name);

            $stub = parent::buildClass($name);

            $stub = $this->replaceFillable($stub,$columns);

            return $stub;

        } else {
            $this->line('=====================');
            $this->warn('Table does not exists');
            $this->line('=====================');
            die;
        }
    }

    protected function checkTableExists($name){
        return Schema::hasTable($name);
    }

    protected function getTableStruct($name){
        $columns = implode('\',\'',Schema::getColumnListing($this->getNameInput($name)));
        return "'$columns'";
    }

    protected function replaceFillable($stub,$structure = null){
        $stub = str_replace('{fillable}',$structure,$stub);
        return $stub;
    }

    public function getStub()
    {
        if ($this->option('template') == 'admin') {
            return __DIR__.'/crud/model/model.admin.stub';
        }

        return __DIR__.'/crud/model/model.plain.stub';
    }
}
