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
 * 小程序图像处理
 */
class Image extends WeChat
{

    /**
     * 本接口提供基于小程序的图片智能裁剪能力
     * @access public
     * @param string $img_url 要检测的图片 url，传这个则不用传 img 参数。
     * @param string $img form-data 中媒体文件标识，有filename、filelength、content-type等信息，传这个则不用穿 img_url
     * @return array
     */
    public function aiCrop($img_url, $img)
    {
        $url = "https://api.weixin.qq.com/cv/img/aicrop?access_token=ACCESS_TOCKEN";
        return $this->callPostApi($url, ['img_url' => $img_url, 'img' => $img], true);
    }

    /**
     * 本接口提供基于小程序的条码/二维码识别的API
     * @access public
     * @param string $img_url 要检测的图片 url，传这个则不用传 img 参数。
     * @param string $img form-data 中媒体文件标识，有filename、filelength、content-type等信息，传这个则不用穿 img_url
     * @return array
     */
    public function scanQRCode($img_url, $img)
    {
        $url = "https://api.weixin.qq.com/cv/img/qrcode?img_url=ENCODE_URL&access_token=ACCESS_TOCKEN";
        return $this->callPostApi($url, ['img_url' => $img_url, 'img' => $img], true);
    }

    /**
     * 本接口提供基于小程序的图片高清化能力
     * @access public
     * @param string $img_url 要检测的图片 url，传这个则不用传 img 参数
     * @param string $img form-data 中媒体文件标识，有filename、filelength、content-type等信息，传这个则不用穿 img_url
     * @return array
     */
    public function superresolution($img_url, $img)
    {
        $url = "https://api.weixin.qq.com/cv/img/qrcode?img_url=ENCODE_URL&access_token=ACCESS_TOCKEN";
        return $this->callPostApi($url, ['img_url' => $img_url, 'img' => $img], true);
    }
}