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

try {

    // 2. 准备公众号配置参数
    $config = include "./config.php";

    // 3. 创建接口实例
    // $wechat = new \axguowen\wechat\services\official\Qrcode($config);
    $wechat = \axguowen\wechat\services\official\Qrcode::instance($config);

    // 4. 获取用户列表
    $result = $wechat->create('场景内容');
    echo var_export($result, true) . PHP_EOL;

    // 5. 创建二维码链接
    $url = $wechat->url($result['ticket']);
    echo var_export($url, true);


} catch (Exception $e) {

    // 出错啦，处理下吧
    echo $e->getMessage() . PHP_EOL;

}