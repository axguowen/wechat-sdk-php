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

// 小程序配置
$config = [
    'appid'     => 'wx6bb7b70258da09c6',
    'appsecret' => '78b7b8d65bd67b078babf951d4342b42',
];

// $mini = new \axguowen\wechat\services\mini\Qrcode($config);
$mini = \axguowen\wechat\services\mini\Qrcode::instance($config);

//echo '<pre>';
try {
    header('Content-type:image/jpeg'); //输出的类型
    // echo $mini->createDefault('pages/index?query=1');
    // echo $mini->createMiniScene('432432', 'pages/index/index');
    echo $mini->createMiniPath('pages/index?query=1');
} catch (Exception $e) {
    var_dump($e->getMessage());
}
