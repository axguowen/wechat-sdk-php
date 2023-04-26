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

/**
 * 微信支付商户
 */
class Pay extends BasicWePay
{

    /**
     * 统一下单
     * @access public
     * @param array $options
     * @return array
     */
    public function createOrder(array $options)
    {
        return Order::instance($this->config->get())->create($options);
    }

    /**
     * 刷卡支付
     * @access public
     * @param array $options
     * @return array
     */
    public function createMicropay($options)
    {
        return Order::instance($this->config->get())->micropay($options);
    }

    /**
     * 创建JsApi及H5支付参数
     * @access public
     * @param string $prepay_id 统一下单预支付码
     * @return array
     */
    public function createParamsForJsApi($prepay_id)
    {
        return Order::instance($this->config->get())->jsapiParams($prepay_id);
    }

    /**
     * 获取APP支付参数
     * @access public
     * @param string $prepay_id 统一下单预支付码
     * @return array
     */
    public function createParamsForApp($prepay_id)
    {
        return Order::instance($this->config->get())->appParams($prepay_id);
    }

    /**
     * 获取支付规则二维码
     * @access public
     * @param string $product_id 商户定义的商品id 或者订单号
     * @return string
     */
    public function createParamsForRuleQrc($product_id)
    {
        return Order::instance($this->config->get())->qrcParams($product_id);
    }

    /**
     * 查询订单
     * @access public
     * @param array $options
     * @return array
     */
    public function queryOrder(array $options)
    {
        return Order::instance($this->config->get())->query($options);
    }

    /**
     * 关闭订单
     * @access public
     * @param string $out_trade_no 商户订单号
     * @return array
     */
    public function closeOrder($out_trade_no)
    {
        return Order::instance($this->config->get())->close($out_trade_no);
    }

    /**
     * 申请退款
     * @access public
     * @param array $options
     * @return array
     */
    public function createRefund(array $options)
    {
        return Refund::instance($this->config->get())->create($options);
    }

    /**
     * 查询退款
     * @access public
     * @param array $options
     * @return array
     */
    public function queryRefund(array $options)
    {
        return Refund::instance($this->config->get())->query($options);
    }

    /**
     * 交易保障
     * @access public
     * @param array $options
     * @return array
     */
    public function report(array $options)
    {
        return Order::instance($this->config->get())->report($options);
    }

    /**
     * 授权码查询openid
     * @access public
     * @param string $authCode 扫码支付授权码，设备读取用户微信中的条码或者二维码信息
     * @return array
     */
    public function queryAuthCode($authCode)
    {
        return Order::instance($this->config->get())->queryAuthCode($authCode);
    }

    /**
     * 下载对账单
     * @access public
     * @param array $options 静音参数
     * @param null|string $outType 输出类型
     * @return bool|string
     */
    public function billDownload(array $options, $outType = null)
    {
        return Bill::instance($this->config->get())->download($options, $outType);
    }

    /**
     * 拉取订单评价数据
     * @access public
     * @param array $options
     * @return array
     */
    public function billCommtent(array $options)
    {
        return Bill::instance($this->config->get())->comment($options);
    }

    /**
     * 企业付款到零钱
     * @access public
     * @param array $options
     * @return array
     */
    public function createTransfers(array $options)
    {
        return Transfers::instance($this->config->get())->create($options);
    }

    /**
     * 查询企业付款到零钱
     * @access public
     * @param string $partner_trade_no 商户调用企业付款API时使用的商户订单号
     * @return array
     */
    public function queryTransfers($partner_trade_no)
    {
        return Transfers::instance($this->config->get())->query($partner_trade_no);
    }

    /**
     * 企业付款到银行卡
     * @access public
     * @param array $options
     * @return array
     * @throws \axguowen\wechat\exception\InvalidDecryptException
     */
    public function createTransfersBank(array $options)
    {
        return TransfersBank::instance($this->config->get())->create($options);
    }

    /**
     * 商户企业付款到银行卡操作进行结果查询
     * @access public
     * @param string $partner_trade_no 商户订单号，需保持唯一
     * @return array
     */
    public function queryTransFresBank($partner_trade_no)
    {
        return TransfersBank::instance($this->config->get())->query($partner_trade_no);
    }
}