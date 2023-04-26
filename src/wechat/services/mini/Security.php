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
 * 小程序内容安全
 */
class Security extends WeChat
{

    /**
     * 校验一张图片是否含有违法违规内容
     * @access public
     * @param string $media 要检测的图片文件，格式支持PNG、JPEG、JPG、GIF，图片尺寸不超过 750px x 1334px
     * @return array
     */
    public function imgSecCheck($media)
    {
        $url = 'https://api.weixin.qq.com/wxa/img_sec_check?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, ['media' => $media], false);
    }

    /**
     * 异步校验图片/音频是否含有违法违规内容
     * @access public
     * @param string $media_url
     * @param string $media_type
     * @return array
     */
    public function mediaCheckAsync($media_url, $media_type)
    {
        $url = 'https://api.weixin.qq.com/wxa/media_check_async?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, ['media_url' => $media_url, 'media_type' => $media_type], true);
    }

    /**
     * 检查一段文本是否含有违法违规内容
     * @access public
     * @param string $content
     * @return array
     */
    public function msgSecCheck($content)
    {
        $url = 'https://api.weixin.qq.com/wxa/msg_sec_check?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, ['content' => $content], true);
    }
}