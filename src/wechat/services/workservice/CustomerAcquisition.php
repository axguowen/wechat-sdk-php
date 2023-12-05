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

namespace axguowen\wechat\services\workservice;

use axguowen\wechat\contract\BasicWeWorkService;
use axguowen\wechat\utils\Tools;

/**
 * 企业微信服务商代获客助手组件类
 */
class CustomerAcquisition extends BasicWeWorkService
{
    /**
     * 服务商AccessToken
     * @var string
     */
    protected $serviceAccessToken = '';

    /**
     * 获取访问 AccessToken
     * @return string
     */
    public function getAccessToken()
    {
        // 当前已存在
        if (!empty($this->accessToken)) {
            return $this->accessToken;
        }
        // 构造缓存键
        $cache_key = $this->config->get('appid') . '_access_token';
        // 从缓存获取
        $this->accessToken = Tools::getCache($cache_key);
        if (!empty($this->accessToken)){
            return $this->accessToken;
        }
        // 获取服务商凭证
        $serviceAccessToken = $this->getServiceAccessToken();

        // 通过接口获取
        list($corpid, $corpsecret) = [$this->config->get('corpid'), $this->config->get('corpsecret')];
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_corp_token?suite_access_token=' . $serviceAccessToken;
        $result = Tools::json2arr(Tools::post($url, Tools::arr2json([
            'auth_corpid' => $corpid,
            'permanent_code' => $corpsecret,
        ])));
        if (isset($result['access_token']) && $result['access_token']) {
            Tools::setCache($cache_key, $result['access_token'], 7000);
        }
        return $this->accessToken = $result['access_token'];
    }

    /**
     * 获取访问服务商凭证
     * @return string
     */
    protected function getServiceAccessToken()
    {
        // 当前已存在
        if (!empty($this->serviceAccessToken)) {
            return $this->serviceAccessToken;
        }
        // 构造缓存键
        $cache_key = $this->config->get('appid') . '_service_access_token';
        // 从缓存获取
        $this->serviceAccessToken = Tools::getCache($cache_key);
        if (!empty($this->serviceAccessToken)){
            return $this->serviceAccessToken;
        }
        // 通过接口获取
        list($appid, $secret, $ticket) = [$this->config->get('appid'), $this->config->get('appsecret'), $this->config->get('suite_ticket')];
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_suite_token';
        $result = Tools::json2arr(Tools::post($url, Tools::arr2json([
            'suite_id' => $appid,
            'suite_secret' => $secret,
            'suite_ticket' => $ticket,
        ])));
        if (isset($result['suite_access_token']) && $result['suite_access_token']) {
            Tools::setCache($cache_key, $result['suite_access_token'], 7000);
        }
        return $this->serviceAccessToken = $result['suite_access_token'];
    }

}