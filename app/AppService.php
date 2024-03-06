<?php
declare (strict_types = 1);

namespace app;

use Symfony\Component\VarDumper\VarDumper;
use think\App;
use think\Service;

/**
 * 应用服务类
 */
class AppService extends Service
{
    public function register()
    {
        // 服务注册
        if (class_exists(VarDumper::class)) {
            $_SERVER['VAR_DUMPER_FORMAT'] = 'tcp://host.docker.internal:9912';
        }

        $this->app->resolving(function ($instance, App $container) {
            if ($instance instanceof BaseController) {
                $container->invoke([$instance, 'initialize'], [], true);
            }
        });
    }

    public function boot()
    {
        // 服务启动
    }
}
