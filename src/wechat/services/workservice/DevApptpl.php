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
 * 企业微信服务商代开发应用模板类
 */
class DevApptpl extends BasicWeWorkService
{
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
        // 通过接口获取
        list($appid, $secret, $ticket) = [$this->config->get('appid'), $this->config->get('appsecret'), $this->config->get('suite_ticket')];
        $url = "https://qyapi.weixin.qq.com/cgi-bin/service/get_suite_token";
        $result = Tools::json2arr(Tools::post($url, Tools::arr2json([
            'suite_id' => $appid,
            'suite_secret' => $secret,
            'suite_ticket' => $ticket,
        ])));
        if (isset($result['suite_access_token']) && $result['suite_access_token']) {
            Tools::setCache($cache_key, $result['suite_access_token'], 7000);
        }
        return $this->accessToken = $result['suite_access_token'];
    }

}