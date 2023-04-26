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
use axguowen\wechat\exception\InvalidResponseException;

/**
 * 微信商户账单及评论
 */
class Bill extends BasicWePay
{
    /**
     * 下载对账单
     * @access public
     * @param array $options 静音参数
     * @param null|string $outType 输出类型
     * @return bool|string
     */
    public function download(array $options, $outType = null)
    {
        $this->params->set('sign_type', 'MD5');
        $params = $this->params->merge($options);
        $params['sign'] = $this->getPaySign($params, 'MD5');
        $result = Tools::post('https://api.mch.weixin.qq.com/pay/downloadbill', Tools::arr2xml($params));
        if (is_array($jsonData = Tools::xml3arr($result))) {
            if ($jsonData['return_code'] !== 'SUCCESS') {
                throw new InvalidResponseException($jsonData['return_msg'], '0');
            }
        }
        return is_null($outType) ? $result : $outType($result);
    }


    /**
     * 拉取订单评价数据
     * @access public
     * @param array $options
     * @return array
     */
    public function comment(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/billcommentsp/batchquerycomment';
        return $this->callPostApi($url, $options, true);
    }
}