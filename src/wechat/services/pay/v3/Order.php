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

namespace axguowen\wechat\services\pay\v3;

use axguowen\wechat\utils\Tools;
use axguowen\wechat\utils\crypt\PayCryptor;

/**
 * 订单支付接口
 */
class Order extends BasicWePay
{
    const WXPAY_H5 = 'h5';
    const WXPAY_APP = 'app';
    const WXPAY_JSAPI = 'jsapi';
    const WXPAY_NATIVE = 'native';

    /**
     * 创建支付订单
     * @access public
     * @param string $type 支付类型
     * @param array $data 支付参数
     * @return array
     * @throws \axguowen\wechat\exception\InvalidArgumentException
     */
    public function create($type, $data)
    {
        $types = [
            'h5'     => '/v3/pay/transactions/h5',
            'app'    => '/v3/pay/transactions/app',
            'jsapi'  => '/v3/pay/transactions/jsapi',
            'native' => '/v3/pay/transactions/native',
        ];
        if (empty($types[$type])) {
            throw new \axguowen\wechat\exception\InvalidArgumentException("Payment {$type} not defined.");
        } else {
            // 创建预支付码
            $result = $this->doRequest('POST', $types[$type], json_encode($data, JSON_UNESCAPED_UNICODE), true);
            if (empty($result['prepay_id'])) return $result;
            // 支付参数签名
            $time = (string)time();
            $appid = $this->config['appid'];
            $prepayId = $result['prepay_id'];
            $nonceStr = Tools::createNoncestr();
            if ($type === 'app') {
                $sign = $this->signBuild(join("\n", [$appid, $time, $nonceStr, $prepayId, '']));
                return ['partnerId' => $this->config['mch_id'], 'prepayId' => $prepayId, 'package' => 'Sign=WXPay', 'nonceStr' => $nonceStr, 'timeStamp' => $time, 'sign' => $sign];
            } elseif ($type === 'jsapi') {
                $sign = $this->signBuild(join("\n", [$appid, $time, $nonceStr, "prepay_id={$prepayId}", '']));
                return ['appId' => $appid, 'timeStamp' => $time, 'nonceStr' => $nonceStr, 'package' => "prepay_id={$prepayId}", 'signType' => 'RSA', 'paySign' => $sign];
            } else {
                return $result;
            }
        }
    }

    /**
     * 支付订单查询
     * @access public
     * @param string $orderNo 订单单号
     * @return array
     */
    public function query($orderNo)
    {
        $pathinfo = "/v3/pay/transactions/out-trade-no/{$orderNo}";
        return $this->doRequest('GET', "{$pathinfo}?mchid={$this->config['mch_id']}", '', true);
    }

    /**
     * 支付通知
     * @access public
     * @return array
     */
    public function notify(array $parameters = [])
    {
        if (empty($parameters)) {
            $body = file_get_contents('php://input');
            $data = json_decode($body, true);
        } else {
            $data = $parameters;
        }

        if (isset($data['resource'])) {
            $aes = new PayCryptor($this->config['mch_v3_key']);
            $data['result'] = $aes->decryptToString(
                $data['resource']['associated_data'],
                $data['resource']['nonce'],
                $data['resource']['ciphertext']
            );
        }
        return $data;
    }
}
