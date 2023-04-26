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

namespace axguowen\wechat\contract;

use axguowen\WeChat;
use axguowen\wechat\utils\Tools;

/**
 * 企业微信基础类
 */
class BasicWeWork extends WeChat
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
        list($appid, $secret) = [$this->config->get('appid'), $this->config->get('appsecret')];
        $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$appid}&corpsecret={$secret}";
        $result = Tools::json2arr(Tools::get($url));
        if (isset($result['access_token']) && $result['access_token']) {
            Tools::setCache($cache_key, $result['access_token'], 7000);
        }
        return $this->accessToken = $result['access_token'];
    }

}