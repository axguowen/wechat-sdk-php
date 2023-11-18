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
use axguowen\wechat\exception\InvalidResponseException;
use axguowen\wechat\exception\LocalCacheException;

/**
 * 微信分账
 */
class ProfitSharing extends BasicWePay
{

    /**
     * 请求单次分账
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     * @throws LocalCacheException
     */
    public function profitSharing(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/profitsharing';
        return $this->callPostApi($url, $options, true);
    }

    /**
     * 请求多次分账
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     * @throws LocalCacheException
     */
    public function multiProfitSharing(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/multiprofitsharing';
        return $this->callPostApi($url, $options, true);
    }

    /**
     * 查询分账结果
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     * @throws LocalCacheException
     */
    public function profitSharingQuery(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/pay/profitsharingquery';
        return $this->callPostApi($url, $options);
    }

    /**
     * 添加分账接收方
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     * @throws LocalCacheException
     */
    public function profitSharingAddReceiver(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/pay/profitsharingaddreceiver';
        return $this->callPostApi($url, $options);
    }

    /**
     * 删除分账接收方
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     * @throws LocalCacheException
     */
    public function profitSharingRemoveReceiver(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/pay/profitsharingremovereceiver';
        return $this->callPostApi($url, $options);
    }

    /**
     * 完结分账
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     * @throws LocalCacheException
     */
    public function profitSharingFinish(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/profitsharingfinish';
        return $this->callPostApi($url, $options, true);
    }

    /**
     * 查询订单待分账金额
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     * @throws LocalCacheException
     */
    public function profitSharingOrderAmountQuery(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/pay/profitsharingorderamountquery';
        return $this->callPostApi($url, $options);
    }

    /**
     * 分账回退
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     * @throws LocalCacheException
     */
    public function profitSharingReturn(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/profitsharingreturn';
        return $this->callPostApi($url, $options, true);
    }

    /**
     * 回退结果查询
     * @param array $options
     * @return array
     * @throws InvalidResponseException
     * @throws LocalCacheException
     */
    public function profitSharingReturnQuery(array $options)
    {
        $url = 'https://api.mch.weixin.qq.com/pay/profitsharingreturnquery';
        return $this->callPostApi($url, $options);
    }
}