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

namespace axguowen\wechat\services\mini;

use axguowen\WeChat;

/**
 * 小程序动态消息
 */
class Message extends WeChat
{
    /**
     * 动态消息，创建被分享动态消息的 activity_id
     * @access public
     * @param array $data
     * @return array
     */
    public function createActivityId($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/activityid/create?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 动态消息，修改被分享的动态消息
     * @access public
     * @param array $data
     * @return array
     */
    public function setUpdatableMsg($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/updatablemsg/send?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 下发小程序和公众号统一的服务消息
     * @access public
     * @param array $data
     * @return array
     */
    public function uniformSend($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/uniform_send?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data, true);
    }
}