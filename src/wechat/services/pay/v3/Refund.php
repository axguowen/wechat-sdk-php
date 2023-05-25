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

/**
 * 订单退款接口
 */
class Refund extends BasicWePay
{
    /**
     * 创建退款订单
     * @access public
     * @param array $data 退款参数
     * @return array
     */
    public function create($data)
    {
        return Order::instance($this->config)->createRefund($data);
        // return $this->doRequest('POST', '/v3/ecommerce/refunds/apply', json_encode($data, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 退款订单查询
     * @access public
     * @param string $refundNo 退款单号
     * @return array
     */
    public function query($refundNo)
    {
        return Order::instance($this->config)->queryRefund($refundNo);
        // $pathinfo = "/v3/ecommerce/refunds/out-refund-no/{$refundNo}";
        // return $this->doRequest('GET', "{$pathinfo}?sub_mchid={$this->config['mch_id']}", '', true);
    }

    /**
     * 获取退款通知
     * @access public
     * @param string $xml
     * @return array
     * @throws \axguowen\wechat\exception\InvalidDecryptException
     * @throws \axguowen\wechat\exception\InvalidResponseException
     */
    public function notify($xml = '')
    {
        return Order::instance($this->config)->notifyRefund($xml);
        /*/
        $data = Tools::xml2arr(empty($xml) ? Tools::getRawInput() : $xml);
        if (!isset($data['return_code']) || $data['return_code'] !== 'SUCCESS') {
            throw new \axguowen\wechat\exception\InvalidResponseException('获取退款通知XML失败！');
        }
        try {
            $key = md5($this->config['mch_v3_key']);
            $decrypt = base64_decode($data['req_info']);
            $response = openssl_decrypt($decrypt, 'aes-256-ecb', $key, OPENSSL_RAW_DATA);
            $data['result'] = Tools::xml2arr($response);
            return $data;
        } catch (\Exception $exception) {
            throw new \axguowen\wechat\exception\InvalidDecryptException($exception->getMessage(), $exception->getCode());
        }
        //*/
    }
}