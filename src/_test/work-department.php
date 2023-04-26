<?php
// +----------------------------------------------------------------------
// | WeChat SDK [WeChat SDK for PHP]
// +----------------------------------------------------------------------
// | WeChat SDK
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: axguowen <axguowen@qq.com>
// +----------------------------------------------------------------------

use axguowen\wechat\contract\BasicWeWork;

$config = include 'work-config.php';

try {
    $url = 'https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token=ACCESS_TOKEN';
    $result = BasicWeWork::instance($config)->callGetApi($url);
    echo '<pre>';
    print_r(BasicWeWork::instance($config)->config->get());
    print_r($result);
    echo '</pre>';
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
