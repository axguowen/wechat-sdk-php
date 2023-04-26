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

    // 4. 获取通知参数
    $data = $wepay->getNotify();
    if ($data['return_code'] === 'SUCCESS' && $data['result_code'] === 'SUCCESS') {
        // @todo 去更新下原订单的支付状态
        $order_no = $data['out_trade_no'];

        // 返回接收成功的回复
        ob_clean();
        echo $wepay->getNotifySuccessReply();
    }

} catch (Exception $e) {

    // 出错啦，处理下吧
    echo $e->getMessage() . PHP_EOL;

}
