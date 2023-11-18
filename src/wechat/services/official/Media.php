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
use axguowen\wechat\utils\Tools;
use axguowen\wechat\exception\InvalidResponseException;

/**
 * 微信素材管理
 */
class Media extends WeChat
{
    /**
     * 新增临时素材
     * @access public
     * @param string $filename 文件名称
     * @param string $type 媒体文件类型(image|voice|video|thumb)
     * @return array
     */
    public function add($filename, $type = 'image')
    {
        if (!in_array($type, ['image', 'voice', 'video', 'thumb'])) {
            throw new InvalidResponseException('Invalid Media Type.', '0');
        }
        $url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=ACCESS_TOKEN&type={$type}";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['media' => Tools::createCurlFile($filename)], false);
    }

    /**
     * 获取临时素材
     * @access public
     * @param string $media_id
     * @param string $outType 返回处理函数
     * @return array|string
     */
    public function get($media_id, $outType = null)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id={$media_id}";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        if($outType=='url') return $url;
        $result = Tools::get($url);
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
     * 更新图文素材
     * @access public
     * @param string $media_id 要修改的图文消息的id
     * @param int $index 要更新的文章在图文消息中的位置（多图文消息时，此字段才有意义），第一篇为0
     * @param array $news 文章内容
     * @return array
     */
    public function updateNews($media_id, $index, $news)
    {
        $data = ['media_id' => $media_id, 'index' => $index, 'articles' => $news];
        $url = "https://api.weixin.qq.com/cgi-bin/material/update_news?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, $data);
    }

    /**
     * 上传图文消息内的图片获取URL
     * @access public
     * @param mixed $filename
     * @return array
     */
    public function uploadImg($filename)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['media' => Tools::createCurlFile($filename)], false);
    }

    /**
     * 新增其他类型永久素材
     * @access public
     * @param mixed $filename 文件名称
     * @param string $type 媒体文件类型(image|voice|video|thumb)
     * @param array $description 包含素材的描述信息
     * @return array
     */
    public function addMaterial($filename, $type = 'image', $description = [])
    {
        if (!in_array($type, ['image', 'voice', 'video', 'thumb'])) {
            throw new InvalidResponseException('Invalid Media Type.', '0');
        }
        $url = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=ACCESS_TOKEN&type={$type}";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['media' => Tools::createCurlFile($filename), 'description' => Tools::arr2json($description)], false);
    }

    /**
     * 获取永久素材
     * @access public
     * @param string $media_id
     * @param null|string $outType 输出类型
     * @return array|string
     */
    public function getMaterial($media_id, $outType = null)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        if($outType=='url') return $url;
        $result = Tools::post($url, ['media_id' => $media_id]);
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
     * 删除永久素材
     * @access public
     * @param string $media_id
     * @return array
     */
    public function delMaterial($media_id)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/material/del_material?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['media_id' => $media_id]);
    }

    /**
     * 获取素材总数
     * @access public
     * @return array
     */
    public function getMaterialCount()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/material/get_materialcount?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

    /**
     * 获取素材列表
     * @access public
     * @param string $type
     * @param int $offset
     * @param int $count
     * @return array
     */
    public function batchGetMaterial($type = 'image', $offset = 0, $count = 20)
    {
        if (!in_array($type, ['image', 'voice', 'video', 'news'])) {
            throw new InvalidResponseException('Invalid Media Type.', '0');
        }
        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=ACCESS_TOKEN";
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, ['type' => $type, 'offset' => $offset, 'count' => $count]);
    }
}