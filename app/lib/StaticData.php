<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace app\lib;

use think\helper\Str;

trait StaticData
{
    protected $staticData = [];

    protected function getStaticData($name, callable $callback = null)
    {
        if (func_num_args() == 1) {
            $callback = $name;
            $trace    = debug_backtrace(false, 2);
            $name     = Str::snake($trace[1]['function']);
        }
        if (!array_key_exists($name, $this->staticData)) {
            $this->staticData[$name] = call_user_func($callback);
        }

        return $this->staticData[$name];
    }
}
