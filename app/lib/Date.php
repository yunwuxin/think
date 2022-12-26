<?php

namespace app\lib;

use Carbon\Carbon;

class Date extends Carbon
{
    public function __construct($time = null, $tz = null)
    {
        if (is_numeric($time)) {
            $time = (int) $time;
        }
        $this->locale('zh-CN');
        $this->localSerializer = function (self $date) {
            return $date->__toString();
        };
        parent::__construct($time, $tz);
    }
}
