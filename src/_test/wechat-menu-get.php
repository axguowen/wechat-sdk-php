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
    // $wechat = new \axguowen\wechat\services\official\Menu($config);
    $wechat = \axguowen\wechat\services\official\Menu::instance($config);

    // 4. 获取菜单数据
    $result = $wechat->get();

    var_export($result);

} catch (Exception $e) {

    // 出错啦，处理下吧
    echo $e->getMessage() . PHP_EOL;

}