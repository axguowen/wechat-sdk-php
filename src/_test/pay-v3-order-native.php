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
    $config = include "./pay-v3-config.php";

    // 3. 创建接口实例
    $wepay = \axguowen\wechat\services\pay\v3\Order::instance($config);

    // 4. 组装支付参数
    $order = (string)time();
    $result = $wepay->create('native', [
        'appid'        => $config['appid'],
        'mchid'        => $config['mch_id'],
        'description'  => '商品描述',
        'out_trade_no' => $order,
        'notify_url'   => 'https://thinkadmin.top',
        'amount'       => ['total' => 2, 'currency' => 'CNY'],
    ]);

    echo '<pre>';
    echo "\n--- 创建支付参数 ---\n";
    var_export($result);

//  array('code_url' => 'weixin://wxpay/bizpayurl?pr=cdJXOVDzz');


    echo "\n\n--- 查询支付参数 ---\n";
    $result = $wepay->query($order);
    var_export($result);

//    array(
//        'amount'           => array('payer_currency' => 'CNY', 'total' => 2),
//        'appid'            => 'wx60a43dd8161666d4',
//        'mchid'            => '1332187001',
//        'out_trade_no'     => '1669027871',
//        'promotion_detail' => array(),
//        'scene_info'       => array('device_id' => ''),
//        'trade_state'      => 'NOTPAY',
//        'trade_state_desc' => '订单未支付',
//    );

    // 创建退款
    $out_refund_no = strval(time());
    $result = $payment->createRefund([
        'out_trade_no'  => $order,
        'out_refund_no' => $out_refund_no,
        'amount'        => [
            'refund'   => 2,
            'total'    => 2,
            'currency' => 'CNY'
        ]
    ]);
    echo "\n--- 创建退款订单2 ---\n";
    var_export($result);

    $result = $payment->queryRefund($out_refund_no);

    echo "\n--- 查询退款订单2 ---\n";
    var_export($result);

} catch (\Exception $exception) {
    // 出错啦，处理下吧
    echo $exception->getMessage() . PHP_EOL;
}