<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
class ServiceMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';


    protected $type = 'Service';
    /**
     * 实现抽象类 getStub 方法
     * @author 晚黎
     * @date   2017-07-26T11:58:44+0800
     * @return [type]                   [description]
     */
    protected function getStub()
    {
        return resource_path('assets/stubs/service.stub');
    }

    /**
     * 重写根命名空间
     * @author 晚黎
     * @date   2017-07-26T13:19:50+0800
     * @return [type]                   [description]
     */
    protected function rootNamespace()
    {
        return $this->laravel->getNamespace().$this->getServiceNamespace();
    }

    /**
     * 重写文件路径方法
     * @author 晚黎
     * @date   2017-07-26T13:26:04+0800
     * @param  [type]                   $name [description]
     * @return [type]                         [description]
     */
    protected function getPath($name)
    {
        $name = str_replace_first($this->rootNamespace(), '', $this->getServiceNamespace().$name);
        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }

    /**
     * [buildClass description]
     * @author 晚黎
     * @date   2017-07-26T13:18:11+0800
     * @param  [type]                   $name [description]
     * @return [type]                         [description]
     */
    protected function buildClass($name)
    {
        $controllerNamespace = $this->getNamespace($name);

        $replace = [];

        $replace["use {$controllerNamespace}\Controller;\n"] = '';

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * 获取 service 目录名称
     * @author 晚黎
     * @date   2017-07-26T13:33:22+0800
     * @return [type]                   [description]
     */
    public function getServiceNamespace()
    {
        return settings('service_namespace', config('admin.global.command.namespace'));
    }
}
