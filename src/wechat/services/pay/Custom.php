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

namespace axguowen\wechat\services\pay;

use axguowen\wechat\contract\BasicWePay;

/**
 * 微信扩展上报海关
 */
class Custom extends BasicWePay
{

    /**
     * 订单附加信息提交接口
     * @access public
     * @param array $options
     * @return array
     */
    public function add(array $options = [])
    {
        $url = 'https://api.mch.weixin.qq.com/cgi-bin/mch/customs/customdeclareorder';
        return $this->callPostApi($url, $options, false, 'MD5', false, false);
    }

    /**
     * 订单附加信息查询接口
     * @access public
     * @param array $options
     * @return array
     */
    public function get(array $options = [])
    {
        $url = 'https://api.mch.weixin.qq.com/cgi-bin/mch/customs/customdeclarequery';
        return $this->callPostApi($url, $options, false, 'MD5', true, false);
    }


    /**
     * 订单附加信息重推接口
     * @access public
     * @param array $options
     * @return array
     */
    public function reset(array $options = [])
    {
        $url = 'https://api.mch.weixin.qq.com/cgi-bin/mch/newcustoms/customdeclareredeclare';
        return $this->callPostApi($url, $options, false, 'MD5', true, false);
    }

}