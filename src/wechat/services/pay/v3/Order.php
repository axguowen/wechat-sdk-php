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
use axguowen\wechat\exception\InvalidResponseException;

/**
 * 直连商户 | 订单支付接口
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
     * @document https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter3_1_1.shtml
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
            if (empty($result['h5_url']) && empty($result['code_url']) && empty($result['prepay_id'])) {
                $message = isset($result['code']) ? "[ {$result['code']} ] " : '';
                $message .= isset($result['message']) ? $result['message'] : json_encode($result, JSON_UNESCAPED_UNICODE);
                throw new InvalidResponseException($message);
            }
            // 支付参数签名
            $time = strval(time());
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
     * @param string $tradeNo 订单单号
     * @return array
     * @document https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter3_1_2.shtml
     */
    public function query($tradeNo)
    {
        $pathinfo = "/v3/pay/transactions/out-trade-no/{$tradeNo}";
        return $this->doRequest('GET', "{$pathinfo}?mchid={$this->config['mch_id']}", '', true);
    }

    /**
     * 关闭支付订单
     * @access public
     * @param string $tradeNo 订单单号
     * @return array
     */
    public function close($tradeNo)
    {
        $data = ['mchid' => $this->config['mch_id']];
        $path = "/v3/pay/transactions/out-trade-no/{$tradeNo}/close";
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 支付通知解析
     * @access public
     * @param array $data
     * @return array
     */
    public function notify(array $data = [])
    {
        if (empty($data)) {
            $body = Tools::getRawInput();
            $data = json_decode($body, true);
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

    /**
     * 创建退款订单
     * @access public
     * @param array $data 退款参数
     * @return array
     * @document https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter3_1_9.shtml
     */
    public function createRefund($data)
    {
        $path = '/v3/refund/domestic/refunds';
        return $this->doRequest('POST', $path, json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 退款订单查询
     * @access public
     * @param string $refundNo 退款单号
     * @return array
     * @document https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter3_1_10.shtml
     */
    public function queryRefund($refundNo)
    {
        $path = "/v3/refund/domestic/refunds/{$refundNo}";
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 申请交易账单
     * @access public
     * @param array|string $params
     * @return array
     * @document https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter3_3_6.shtml
     */
    public function tradeBill($params)
    {
        $path = '/v3/bill/tradebill?' . is_array($params) ? http_build_query($params) : $params;
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 申请资金账单
     * @access public
     * @param array|string $params
     * @return array
     * @document https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter3_3_7.shtml
     */
    public function fundflowBill($params)
    {
        $path = '/v3/bill/fundflowbill?' . is_array($params) ? http_build_query($params) : $params;
        return $this->doRequest('GET', $path, '', true);
    }

    /**
     * 下载账单文件
     * @access public
     * @param string $fileurl
     * @return string 二进制 Excel 内容
     * @document https://pay.weixin.qq.com/wiki/doc/apiv3_partner/apis/chapter7_6_1.shtml
     */
    public function downloadBill($fileurl)
    {
        return $this->doRequest('GET', $fileurl, '', false, false);
    }
}
