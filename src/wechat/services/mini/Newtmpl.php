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
 * 公众号小程序订阅消息支持
 */
class Newtmpl extends WeChat
{
    /**
     * 添加小程序账号类目
     * @access public
     * @param array $data 类目信息列表
     * @return array
     */
    public function addCategory($data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/addcategory?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 获取小程序账号的类目
     * @access public
     * @return array
     */
    public function getCategory()
    {
        $url = 'https://api.weixin.qq.com/wxaapi/newtmpl/getcategory?access_token=ACCESS_TOKEN';
        return $this->callGetApi($url);
    }

    /**
     * 删除小程序账号的类目
     * @access public
     * @return array
     */
    public function deleteCategory()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/wxopen/deletecategory?access_token=TOKEN';
        return $this->callPostApi($url, [], true);
    }

    /**
     * 获取帐号所属类目下的公共模板标题
     * @access public
     * @param string $ids 类目 id，多个用逗号隔开
     * @return array
     */
    public function getPubTemplateTitleList($ids)
    {
        $url = 'https://api.weixin.qq.com/wxaapi/newtmpl/getpubtemplatetitles?access_token=ACCESS_TOKEN';
        $url .= '&' . http_build_query(['ids' => $ids, 'start' => '0', 'limit' => '30']);
        return $this->callGetApi($url);
    }

    /**
     * 获取模板标题下的关键词列表
     * @access public
     * @param string $tid 模板标题 id，可通过接口获取
     * @return array
     */
    public function getPubTemplateKeyWordsById($tid)
    {
        $url = 'https://api.weixin.qq.com/wxaapi/newtmpl/getpubtemplatekeywords?access_token=ACCESS_TOKEN';
        $url .= '&' . http_build_query(['tid' => $tid]);
        return $this->callGetApi($url);
    }

    /**
     * 组合模板并添加至帐号下的个人模板库
     * @access public
     * @param string $tid 模板标题 id，可通过接口获取，也可登录小程序后台查看获取
     * @param array $kidList 开发者自行组合好的模板关键词列表，关键词顺序可以自由搭配（例如 [3,5,4] 或 [4,5,3]），最多支持5个，最少2个关键词组合
     * @param string $sceneDesc 服务场景描述，15个字以内
     * @return array
     */
    public function addTemplate($tid, array $kidList, $sceneDesc = '')
    {
        $url = 'https://api.weixin.qq.com/wxaapi/newtmpl/addtemplate?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, ['tid' => $tid, 'kidList' => $kidList, 'sceneDesc' => $sceneDesc], false);
    }

    /**
     * 获取当前帐号下的个人模板列表
     * @access public
     * @return array
     */
    public function getTemplateList()
    {
        $url = 'https://api.weixin.qq.com/wxaapi/newtmpl/gettemplate?access_token=ACCESS_TOKEN';
        return $this->callGetApi($url);
    }

    /**
     * 删除帐号下的个人模板
     * @access public
     * @param string $priTmplId 要删除的模板id
     * @return array
     */
    public function delTemplate($priTmplId)
    {
        $url = 'https://api.weixin.qq.com/wxaapi/newtmpl/deltemplate?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, ['priTmplId' => $priTmplId], true);
    }

    /**
     * 发送订阅消息
     * @access public
     * @param array $data 发送的消息对象数组
     * @return array
     */
    public function send(array $data)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data, true);
    }
}