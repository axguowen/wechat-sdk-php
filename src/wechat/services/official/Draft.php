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
 * 微信草稿箱管理
 */
class Draft extends WeChat
{
    /**
     * 新建草稿
     * @access public
     * @param $articles
     * @return array
     */
    public function add($articles)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/draft/add?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['articles' => $articles]);
    }

    /**
     * 获取草稿
     * @access public
     * @param string $media_id
     * @param string $outType 返回处理函数
     * @return array
     */
    public function get($media_id, $outType = null)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/draft/get?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['media_id' => $media_id]);
    }


    /**
     * 删除草稿
     * @access public
     * @param string $media_id
     * @return array
     */
    public function delete($media_id)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/draft/delete?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['media_id' => $media_id]);
    }

    /**
     * 新增图文素材
     * @access public
     * @param array $data 文件名称
     * @return array
     */
    public function addNews($data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/material/add_news?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, $data);
    }

    /**
     * 修改草稿
     * @access public
     * @param string $media_id 要修改的图文消息的id
     * @param int $index 要更新的文章在图文消息中的位置（多图文消息时，此字段才有意义），第一篇为0
     * @param $articles
     * @return array
     */
    public function update($media_id, $index, $articles)
    {
        $data = ['media_id' => $media_id, 'index' => $index, 'articles' => $articles];
        $url = "https://api.weixin.qq.com/cgi-bin/draft/update?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, $data);
    }

    /**
     * 获取草稿总数
     * @access public
     * @return array
     */
    public function getCount()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/draft/count?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

    /**
     * 获取草稿列表
     * @access public
     * @param int $offset 从全部素材的该偏移位置开始返回，0表示从第一个素材返回
     * @param int $count 返回素材的数量，取值在1到20之间
     * @param int $no_content 1 表示不返回 content 字段，0 表示正常返回，默认为 0
     * @return array
     */
    public function batchGet($offset = 0, $count = 20, $no_content = 0)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/draft/batchget?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['no_content' => $no_content, 'offset' => $offset, 'count' => $count]);
    }

}
