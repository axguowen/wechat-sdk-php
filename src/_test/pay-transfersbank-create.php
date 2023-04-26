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
        'enc_bank_no'      => '6212263602037318102',
        'enc_true_name'    => '邹景立',
        'bank_code'        => '1002',
        'amount'           => '100',
        'desc'             => '打款测试',
    ];
    echo '<pre>';
    $result = $wepay->createTransfersBank($options);
    var_export($result);

} catch (Exception $e) {

    // 出错啦，处理下吧
    echo $e->getMessage() . PHP_EOL;

}