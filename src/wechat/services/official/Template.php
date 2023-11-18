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

/**
 * 模板消息
 */
class Template extends WeChat
{
    /**
     * 设置所属行业
     * @param string $industry_id1 公众号模板消息所属行业编号
     * @param string $industry_id2 公众号模板消息所属行业编号
     * @return array
     */
    public function setIndustry($industry_id1, $industry_id2)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['industry_id1' => $industry_id1, 'industry_id2' => $industry_id2]);
    }

    /**
     * 获取设置的行业信息
     * @return array
     */
    public function getIndustry()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

    /**
     * 获得模板ID
     * @param string $templateIdShort 板库中模板的编号，有“TM**”和“OPENTM**”等形式
     * @param array $keywordNameList 选用的类目模板的关键词
     * @return array
     */
    public function addTemplate($templateIdShort, $keywordNameList = [])
    {
        $url = "https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['template_id_short' => $templateIdShort, 'keyword_name_list' => $keywordNameList]);
    }

    /**
     * 获取模板列表
     * @return array
     */
    public function getAllPrivateTemplate()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

    /**
     * 删除模板ID
     * @param string $tpl_id 公众帐号下模板消息ID
     * @return array
     */
    public function delPrivateTemplate($tpl_id)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/template/del_private_template?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['template_id' => $tpl_id]);
    }

    /**
     * 发送模板消息
     * @param array $data
     * @return array
     */
    public function send(array $data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, $data);
    }


}