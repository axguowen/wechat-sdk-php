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
 * 小程序直播接口
 */
class Live extends WeChat
{
    /**
     * 创建直播间
     * @access public
     * @param array $data
     * @return array
     */
    public function create($data)
    {
        $url = 'https://api.weixin.qq.com/wxaapi/broadcast/room/create?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 获取直播房间列表
     * @access public
     * @param integer $start 起始拉取房间
     * @param integer $limit 每次拉取的个数上限
     * @return array
     */
    public function getLiveList($start = 0, $limit = 10)
    {
        $url = 'https://api.weixin.qq.com/wxa/business/getliveinfo?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, ['start' => $start, 'limit' => $limit], true);
    }

    /**
     * 获取回放源视频
     * @access public
     * @param array $data
     * @return array
     */
    public function getLiveInfo($data = [])
    {
        $url = 'https://api.weixin.qq.com/wxa/business/getliveinfo?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 直播间导入商品
     * @access public
     * @param array $data
     * @return array
     */
    public function addLiveGoods($data = [])
    {
        $url = 'https://api.weixin.qq.com/wxaapi/broadcast/room/addgoods?access_token=ACCESS_TOKEN';
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 商品添加并提审
     * @access public
     * @param array $data
     * @return array
     */
    public function addGoods($data)
    {
        $url = "https://api.weixin.qq.com/wxaapi/broadcast/goods/add?access_token=ACCESS_TOKEN";
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 商品撤回审核
     * @access public
     * @param array $data
     * @return array
     */
    public function resetAuditGoods($data)
    {
        $url = "https://api.weixin.qq.com/wxaapi/broadcast/goods/resetaudit?access_token=ACCESS_TOKEN";
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 重新提交审核
     * @access public
     * @param array $data
     * @return array
     */
    public function auditGoods($data)
    {
        $url = "https://api.weixin.qq.com/wxaapi/broadcast/goods/audit?access_token=ACCESS_TOKEN";
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 删除商品
     * @access public
     * @param array $data
     * @return array
     */
    public function deleteGoods($data)
    {
        $url = "https://api.weixin.qq.com/wxaapi/broadcast/goods/delete?access_token=ACCESS_TOKEN";
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 更新商品
     * @access public
     * @param array $data
     * @return array
     */
    public function updateGoods($data)
    {
        $url = "https://api.weixin.qq.com/wxaapi/broadcast/goods/update?access_token=ACCESS_TOKEN";
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 获取商品状态
     * @access public
     * @param array $data
     * @return array
     */
    public function stateGoods($data)
    {
        $url = "https://api.weixin.qq.com/wxa/business/getgoodswarehouse?access_token=ACCESS_TOKEN";
        return $this->callPostApi($url, $data, true);
    }

    /**
     * 获取商品列表
     * @access public
     * @param array $data
     * @return array
     */
    public function getGoods($data)
    {
        $url = "https://api.weixin.qq.com/wxaapi/broadcast/goods/getapproved?access_token=ACCESS_TOKEN";
        return $this->callPostApi($url, $data, true);
    }
}