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

namespace axguowen\wechat\services\pay;

use axguowen\wechat\contract\BasicWePay;
use axguowen\wechat\utils\Tools;

/**
 * 微信商户退款
 */
class Refund extends BasicWePay
{

    /**
     * 创建退款订单
     * @access public
     * @param array $options
     * @return array
     */
    public function create(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
        return $this->callPostApi($url, $options, true);
    }

    /**
     * 查询退款
     * @access public
     * @param array $options
     * @return array
     */
    public function query(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/pay/refundquery';
        return $this->callPostApi($url, $options);
    }

    /**
     * 获取退款通知
     * @access public
     * @param string $xml
     * @return array
     * @throws \axguowen\wechat\exception\InvalidDecryptException
     * @throws \axguowen\wechat\exception\InvalidResponseException
     */
    public function getNotify($xml = '')
    {
        $data = Tools::xml2arr(empty($xml) ? Tools::getRawInput() : $xml);
        if (!isset($data['return_code']) || $data['return_code'] !== 'SUCCESS') {
            throw new \axguowen\wechat\exception\InvalidResponseException('获取退款通知XML失败！');
        }
        try {
            $key = md5($this->config->get('mch_key'));
            $decrypt = base64_decode($data['req_info']);
            $response = openssl_decrypt($decrypt, 'aes-256-ecb', $key, OPENSSL_RAW_DATA);
            $data['result'] = Tools::xml2arr($response);
            return $data;
        } catch (\Exception $exception) {
            throw new \axguowen\wechat\exception\InvalidDecryptException($exception->getMessage(), $exception->getCode());
        }
    }
}