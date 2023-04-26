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
 * 微信小程序插件管理
 */
class Plugs extends WeChat
{
    /**
     * 1.申请使用插件
     * @access public
     * @param string $plugin_appid 插件appid
     * @return array
     */
    public function apply($plugin_appid)
    {
        $url = 'https://api.weixin.qq.com/wxa/plugin?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, ['action' => 'apply', 'plugin_appid' => $plugin_appid], true);
    }

    /**
     * 2.查询已添加的插件
     * @access public
     * @return array
     */
    public function getList()
    {
        $url = 'https://api.weixin.qq.com/wxa/plugin?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, ['action' => 'list'], true);
    }

    /**
     * 3.删除已添加的插件
     * @access public
     * @param string $plugin_appid 插件appid
     * @return array
     */
    public function unbind($plugin_appid)
    {
        $url = 'https://api.weixin.qq.com/wxa/plugin?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, ['action' => 'unbind', 'plugin_appid' => $plugin_appid], true);
    }

    /**
     * 获取当前所有插件使用方
     * 修改插件使用申请的状态
     * @access public
     * @param array $data
     * @return array
     */
    public function devplugin($data)
    {
        $url = 'https://api.weixin.qq.com/wxa/devplugin?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 4.获取当前所有插件使用方（供插件开发者调用）
     * @access public
     * @param integer $page 拉取第page页的数据
     * @param integer $num 表示每页num条记录
     * @return array
     */
    public function devApplyList($page = 1, $num = 10)
    {
        $url = 'https://api.weixin.qq.com/wxa/plugin?access_token=ACCESS_TOKEN';
        $data = ['action' => 'dev_apply_list', 'page' => $page, 'num' => $num];
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 5.修改插件使用申请的状态（供插件开发者调用）
     * @access public
     * @param string $action dev_agree：同意申请；dev_refuse：拒绝申请；dev_delete：删除已拒绝的申请者
     * @return array
     */
    public function devAgree($action = 'dev_agree')
    {
        $url = 'https://api.weixin.qq.com/wxa/plugin?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, ['action' => $action], true);
    }
}