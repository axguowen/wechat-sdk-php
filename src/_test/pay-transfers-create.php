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
    // $wepay = new \axguowen\wechat\services\pay\Pay($config);
    $wepay = \axguowen\wechat\services\pay\Pay::instance($config);

    // 4. 组装参数，可以参考官方商户文档
    $options = [
        'partner_trade_no' => time(),
        'openid'           => 'o38gps3vNdCqaggFfrBRCRikwlWY',
        'check_name'       => 'NO_CHECK',
        'amount'           => '100',
        'desc'             => '企业付款操作说明信息',
        'spbill_create_ip' => '127.0.0.1',
    ];
    $result = $wepay->createTransfers($options);
    echo '<pre>';
    var_export($result);
    $result = $wepay->queryTransfers($options['partner_trade_no']);
    var_export($result);

} catch (Exception $e) {

    // 出错啦，处理下吧
    echo $e->getMessage() . PHP_EOL;

}