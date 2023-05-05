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
 * 普通商户商家分账
 */
class ProfitSharing extends BasicWePay
{
    /**
     * 请求分账
     * @access public
     * @param array $options
     * @return array
     */
    public function create($options)
    {
        $options['appid'] = $this->config['appid'];
        return $this->doRequest('POST', '/v3/profitsharing/orders', json_encode($options, JSON_UNESCAPED_UNICODE), true);
    }


    /**
     * 查询分账结果
     * @access public
     * @param string $outOrderNo 商户分账单号
     * @param string $transactionId 微信订单号
     * @return array
     */
    public function query($outOrderNo, $transactionId)
    {
        $pathinfo = "/v3/profitsharing/orders/{$outOrderNo}?&transaction_id={$transactionId}";
        return $this->doRequest('GET', $pathinfo, '', true);
    }

    /**
     * 解冻剩余资金
     * @access public
     * @param array $options
     * @return array
     */
    public function unfreeze($options)
    {
        return $this->doRequest('POST', '/v3/profitsharing/orders/unfreeze', json_encode($options, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 查询剩余待分金额
     * @access public
     * @param string $transactionId 微信订单号
     * @return array
     */
    public function amounts($transactionId)
    {
        $pathinfo = "/v3/profitsharing/transactions/{$transactionId}/amounts";
        return $this->doRequest('GET', $pathinfo, '', true);
    }

    /**
     * 添加分账接收方
     * @access public
     * @param array $options
     * @return array
     */
    public function addReceiver($options)
    {
        $options['appid'] = $this->config['appid'];
        return $this->doRequest('POST', "/v3/profitsharing/receivers/add", json_encode($options, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 删除分账接收方
     * @access public
     * @param array $options
     * @return array
     */
    public function deleteReceiver($options)
    {
        $options['appid'] = $this->config['appid'];
        return $this->doRequest('POST', "/v3/profitsharing/receivers/delete", json_encode($options, JSON_UNESCAPED_UNICODE), true);
    }
}