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
 * 小程序运维中心
 */
class Operation extends WeChat
{

    /**
     * 实时日志查询
     * @access public
     * @param array $data
     * @return array
     */
    public function realtimelogSearch($data)
    {
        $url = 'https://api.weixin.qq.com/wxaapi/userlog/userlog_search?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data, true);
    }
}