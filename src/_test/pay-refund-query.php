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
        'transaction_id' => '1008450740201411110005820873',
        // 'out_trade_no'   => '商户订单号',
        // 'out_refund_no' => '商户退款单号'
        // 'refund_id' => '微信退款单号',
    ];
    $result = $wepay->queryRefund($options);

    var_export($result);

} catch (Exception $e) {

    // 出错啦，处理下吧
    echo $e->getMessage() . PHP_EOL;

}