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
use axguowen\wechat\utils\Tools;

/**
 * 微信小程序二维码管理
 */
class Qrcode extends WeChat
{

    /**
     * 获取小程序码（永久有效）
     * 接口A: 适用于需要的码数量较少的业务场景
     * @access public
     * @param string $path 不能为空，最大长度 128 字节
     * @param integer $width 二维码的宽度
     * @param bool $auto_color 自动配置线条颜色，如果颜色依然是黑色，则说明不建议配置主色调
     * @param array $line_color auto_color 为 false 时生效
     * @param boolean $is_hyaline 是否需要透明底色
     * @param null|string $outType 输出类型
     * @return array|string
     */
    public function createMiniPath($path, $width = 430, $auto_color = false, $line_color = ["r" => "0", "g" => "0", "b" => "0"], $is_hyaline = true, $outType = null)
    {
        $url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        $data = ['path' => $path, 'width' => $width, 'auto_color' => $auto_color, 'line_color' => $line_color, 'is_hyaline' => $is_hyaline];
        $result = Tools::post($url, Tools::arr2json($data));
        if (is_array($json = json_decode($result, true))) {
            if (!$this->isTry && isset($json['errcode']) && in_array($json['errcode'], ['40014', '40001', '41001', '42001'])) {
                [$this->delAccessToken(), $this->isTry = true];
                return call_user_func_array([$this, $this->currentMethod['method']], $this->currentMethod['arguments']);
            }
            return Tools::json2arr($result);
        }
        return is_null($outType) ? $result : $outType($result);
    }

    /**
     * 获取小程序码（永久有效）
     * 接口B：适用于需要的码数量极多的业务场景
     * @access public
     * @param string $scene 最大32个可见字符，只支持数字
     * @param string $page 必须是已经发布的小程序存在的页面
     * @param integer $width 二维码的宽度
     * @param bool $auto_color 自动配置线条颜色，如果颜色依然是黑色，则说明不建议配置主色调
     * @param array $line_color auto_color 为 false 时生效
     * @param boolean $is_hyaline 是否需要透明底色
     * @param null|string $outType 输出类型
     * @param array $extra 其他参数
     * @return array|string
     */
    public function createMiniScene($scene, $page, $width = 430, $auto_color = false, $line_color = ["r" => "0", "g" => "0", "b" => "0"], $is_hyaline = true, $outType = null, array $extra = [])
    {
        $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=ACCESS_TOKEN';
        $data = array_merge(['scene' => $scene, 'width' => $width, 'auto_color' => $auto_color, 'page' => $page, 'line_color' => $line_color, 'is_hyaline' => $is_hyaline], $extra);
        $this->registerApi($url, __FUNCTION__, func_get_args());
        $result = Tools::post($url, Tools::arr2json($data));
        if (is_array($json = json_decode($result, true))) {
            if (!$this->isTry && isset($json['errcode']) && in_array($json['errcode'], ['40014', '40001', '41001', '42001'])) {
                [$this->delAccessToken(), $this->isTry = true];
                return call_user_func_array([$this, $this->currentMethod['method']], $this->currentMethod['arguments']);
            }
            return Tools::json2arr($result);
        }
        return is_null($outType) ? $result : $outType($result);
    }

    /**
     * 获取小程序二维码（永久有效）
     * 接口C：适用于需要的码数量较少的业务场景
     * @access public
     * @param string $path 不能为空，最大长度 128 字节
     * @param integer $width 二维码的宽度
     * @param null|string $outType 输出类型
     * @return array|string
     */
    public function createDefault($path, $width = 430, $outType = null)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=ACCESS_TOKEN';
        $this->registerApi($url, __FUNCTION__, func_get_args());
        $result = Tools::post($url, Tools::arr2json(['path' => $path, 'width' => $width]));
        if (is_array($json = json_decode($result, true))) {
            if (!$this->isTry && isset($json['errcode']) && in_array($json['errcode'], ['40014', '40001', '41001', '42001'])) {
                [$this->delAccessToken(), $this->isTry = true];
                return call_user_func_array([$this, $this->currentMethod['method']], $this->currentMethod['arguments']);
            }
            return Tools::json2arr($result);
        }
        return is_null($outType) ? $result : $outType($result);
    }
}