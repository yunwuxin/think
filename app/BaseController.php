<?php
declare (strict_types = 1);

namespace app;

use think\App;
use think\exception\ValidateException;
use think\Validate;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    /**
     * 构造方法
     * @access public
     * @param App $app 应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = $this->app->request;
    }

    protected function initialize()
    {
    }

    protected function middleware($middleware, ...$params)
    {
        $options = [];

        $this->middleware[] = [
            'middleware' => [$middleware, $params],
            'options'    => &$options,
        ];

        return new class($options) {
            protected $options;

            public function __construct(array &$options)
            {
                $this->options = &$options;
            }

            public function only($methods)
            {
                $this->options['only'] = is_array($methods) ? $methods : func_get_args();
                return $this;
            }

            public function except($methods)
            {
                $this->options['except'] = is_array($methods) ? $methods : func_get_args();

                return $this;
            }
        };
    }

    /**
     * 验证数据
     * @access protected
     * @param string|array $validate 验证器名或者验证规则数组
     * @param array $message 提示信息
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate($validate, array $message = [])
    {
        $v = new Validate();
        $v->rule(array_filter($validate));
        $v->message($message);
        $v->batch(true);

        $params = $this->request->all();

        $v->failException(true)->check($params);

        $data = [];

        foreach ($validate as $key => $rule) {
            if (strpos($key, '|')) {
                // 字段|描述 用于指定属性名称
                [$key] = explode('|', $key);
            }
            if (array_key_exists($key, $params)) {
                $data[$key] = $params[$key];
            }
        }

        return $data;
    }

}
