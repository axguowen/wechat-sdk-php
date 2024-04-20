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

namespace axguowen\wechat\services\official;

use axguowen\WeChat;
use axguowen\wechat\utils\Tools;
use axguowen\wechat\exception\InvalidResponseException;

/**
 * 微信前端支持
 */
class Script extends WeChat
{

    /**
     * 删除JSAPI授权TICKET
     * @access public
     * @param string $type TICKET类型(wx_card|jsapi)
     * @param string $appid 强制指定有效APPID
     * @return void
     */
    public function delTicket($type = 'jsapi', $appid = null)
    {
        is_null($appid) && $appid = $this->config->get('appid');
        $cache_name = "{$appid}_ticket_{$type}";
        Tools::delCache($cache_name);
    }

    /**
     * 获取JSAPI_TICKET接口
     * @access public
     * @param string $type TICKET类型(wx_card|jsapi)
     * @param string $appid 强制指定有效APPID
     * @return string
     */
    public function getTicket($type = 'jsapi', $appid = null)
    {
        is_null($appid) && $appid = $this->config->get('appid');
        $cache_name = "{$appid}_ticket_{$type}";
        $ticket = Tools::getCache($cache_name);
        if (empty($ticket)) {
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=ACCESS_TOKEN&type={$type}";
            $this->registerApi($url, __FUNCTION__, func_get_args());
            $result = $this->httpGetForJson($url);
            if (empty($result['ticket'])) {
                throw new InvalidResponseException('Invalid Resoponse Ticket.', '0');
            }
            $ticket = $result['ticket'];
            Tools::setCache($cache_name, $ticket, 7000);
        }
        return $ticket;
    }

    /**
     * 获取JsApi使用签名
     * @access public
     * @param string $url 网页的URL
     * @param array $jsApiList 需初始化的 jsApiList
     * @param string $appid 用于多个appid时使用(可空)
     * @param string $ticket 强制指定ticket
     * @return array
     */
    public function getJsSign($url, $jsApiList = null, $appid = null, $ticket = null)
    {
        list($url,) = explode('#', $url);
        is_null($ticket) && $ticket = $this->getTicket('jsapi');
        is_null($appid) && $appid = $this->config->get('appid');
        is_null($jsApiList) && $jsApiList = [
            'updateAppMessageShareData', 'updateTimelineShareData', 'onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareQZone',
            'startRecord', 'stopRecord', 'onVoiceRecordEnd', 'playVoice', 'pauseVoice', 'stopVoice', 'onVoicePlayEnd', 'uploadVoice', 'downloadVoice',
            'chooseImage', 'previewImage', 'uploadImage', 'downloadImage', 'translateVoice', 'getNetworkType', 'openLocation', 'getLocation',
            'hideOptionMenu', 'showOptionMenu', 'hideMenuItems', 'showMenuItems', 'hideAllNonBaseMenuItem', 'showAllNonBaseMenuItem',
            'closeWindow', 'scanQRCode', 'chooseWXPay', 'openProductSpecificView', 'addCard', 'chooseCard', 'openCard',
        ];
        $data = ["url" => $url, "timestamp" => '' . time(), "jsapi_ticket" => $ticket, "noncestr" => Tools::createNoncestr(16)];
        return [
            'debug'     => false,
            "appId"     => $appid,
            "nonceStr"  => $data['noncestr'],
            "timestamp" => $data['timestamp'],
            "signature" => $this->getSignature($data, 'sha1'),
            'jsApiList' => $jsApiList,
        ];
    }

    /**
     * 数据生成签名
     * @access public
     * @param array $data 签名数组
     * @param string $method 签名方法
     * @param array $params 签名参数
     * @return bool|string 签名值
     */
    protected function getSignature($data, $method = "sha1", $params = [])
    {
        ksort($data);
        if (!function_exists($method)) return false;
        foreach ($data as $k => $v) $params[] = "{$k}={$v}";
        return $method(join('&', $params));
    }
}