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
 * 小程序 URL-Scheme
 */
class Scheme extends WeChat
{

    /**
     * 创建 URL-Scheme
     * @access public
     * @param array $data
     * @return array
     */
    public function create($data)
    {
        $url = 'https://api.weixin.qq.com/wxa/generatescheme?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 查询 URL-Scheme
     * @access public
     * @param string $scheme
     * @return array
     */
    public function query($scheme)
    {
        $url = 'https://api.weixin.qq.com/wxa/queryscheme?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, ['scheme' => $scheme], true);
    }

    /**
     * 创建 URL-Link
     * @access public
     * @param array $data
     * @return array
     */
    public function urlLink($data)
    {
        $url = "https://api.weixin.qq.com/wxa/generate_urllink?access_token=ACCESS_TOKEN";
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 查询 URL-Link
     * @access public
     * @param string $urllink
     * @return array
     */
    public function urlQuery($urllink)
    {
        $url = 'https://api.weixin.qq.com/wxa/query_urllink?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, ['url_link' => $urllink], true);
    }
}