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

namespace axguowen\wechat\services\open;

use axguowen\WeChat;

/**
 * 微信网页授权
 */
class Oauth extends WeChat
{

    /**
     * Oauth 授权跳转接口
     * @access public
     * @param string $redirect_url 授权回跳地址
     * @param string $state 为重定向后会带上state参数(填写a-zA-Z0-9的参数值，最多128字节)
     * @param string $scope 授权类类型(可选值snsapi_base|snsapi_userinfo)
     * @return string
     */
    public function getOauthRedirect($redirect_url, $state = '', $scope = 'snsapi_base')
    {
        $appid = $this->config->get('appid');
        $redirect_uri = urlencode($redirect_url);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
    }

    /**
     * 通过 code 获取 AccessToken 和 openid
     * @access public
     * @param string $code 授权Code值，不传则取GET参数
     * @return array
     */
    public function getOauthAccessToken($code = '')
    {
        $appid = $this->config->get('appid');
        $appsecret = $this->config->get('appsecret');
        $code = $code ? $code : (isset($_GET['code']) ? $_GET['code'] : '');
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$appsecret}&code={$code}&grant_type=authorization_code";
        return $this->httpGetForJson($url);
    }

    /**
     * 刷新AccessToken并续期
     * @access public
     * @param string $refresh_token
     * @return array
     */
    public function getOauthRefreshToken($refresh_token)
    {
        $appid = $this->config->get('appid');
        $url = "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={$appid}&grant_type=refresh_token&refresh_token={$refresh_token}";
        return $this->httpGetForJson($url);
    }

    /**
     * 检验授权凭证（access_token）是否有效
     * @access public
     * @param string $access_token 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
     * @param string $openid 用户的唯一标识
     * @return array
     */
    public function checkOauthAccessToken($access_token, $openid)
    {
        $url = "https://api.weixin.qq.com/sns/auth?access_token={$access_token}&openid={$openid}";
        return $this->httpGetForJson($url);
    }

    /**
     * 拉取用户信息(需scope为 snsapi_userinfo)
     * @access public
     * @param string $access_token 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
     * @param string $openid 用户的唯一标识
     * @param string $lang 返回国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语
     * @return array
     */
    public function getUserInfo($access_token, $openid, $lang = 'zh_CN')
    {
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang={$lang}";
        return $this->httpGetForJson($url);
    }
}
