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
