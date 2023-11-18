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

namespace axguowen\wechat\services\pay\v3;

/**
 * 普通商户商家转账到零钱
 */
class Transfers extends BasicWePay
{
    /**
     * 发起商家批量转账
     * @access public
     * @param array $body
     * @return array
     * @link https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter4_3_1.shtml
     */
    public function batchs($body)
    {
        if (empty($body['appid'])) {
            $body['appid'] = $this->config['appid'];
        }
        if (isset($body['transfer_detail_list']) && is_array($body['transfer_detail_list'])) {
            foreach ($body['transfer_detail_list'] as &$item) if (isset($item['user_name'])) {
                $item['user_name'] = $this->rsaEncode($item['user_name']);
            }
        }
        if (empty($body['total_num'])) {
            $body['total_num'] = count($body['transfer_detail_list']);
        }
        return $this->doRequest('POST', '/v3/transfer/batches', json_encode($body, JSON_UNESCAPED_UNICODE), true);
    }

    /**
     * 通过微信批次单号查询批次单
     * @access public
     * @param string $batchId 微信批次单号(二选一)
     * @param string $outBatchNo 商家批次单号(二选一)
     * @param boolean $needQueryDetail 查询指定状态
     * @param integer $offset 请求资源的起始位置
     * @param integer $limit 最大明细条数
     * @param string $detailStatus 查询指定状态
     * @return array
     */
    public function query($batchId = '', $outBatchNo = '', $needQueryDetail = true, $offset = 0, $limit = 20, $detailStatus = 'ALL')
    {
        if (empty($batchId)) {
            $pathinfo = "/v3/transfer/batches/out-batch-no/{$outBatchNo}";
        } else {
            $pathinfo = "/v3/transfer/batches/batch-id/{$batchId}";
        }
        $params = http_build_query([
            'limit'             => $limit,
            'offset'            => $offset,
            'detail_status'     => $detailStatus,
            'need_query_detail' => $needQueryDetail ? 'true' : 'false',
        ]);
        return $this->doRequest('GET', "{$pathinfo}?{$params}", '', true);
    }

    /**
     * 通过微信明细单号查询明细单
     * @access public
     * @param string $batchId 微信批次单号
     * @param string $detailId 微信支付系统内部区分转账批次单下不同转账明细单的唯一标识
     * @return array
     */
    public function detailBatchId($batchId, $detailId)
    {
        $pathinfo = "/v3/transfer/batches/batch-id/{$batchId}/details/detail-id/{$detailId}";
        return $this->doRequest('GET', $pathinfo, '', true);
    }

    /**
     * 通过商家明细单号查询明细单
     * @access public
     * @param string $outBatchNo 商户系统内部的商家批次单号，在商户系统内部唯一
     * @param string $outDetailNo 商户系统内部区分转账批次单下不同转账明细单的唯一标识
     * @return array
     */
    public function detailOutBatchNo($outBatchNo, $outDetailNo)
    {
        $pathinfo = "/v3/transfer/batches/out-batch-no/{$outBatchNo}/details/out-detail-no/{$outDetailNo}";
        return $this->doRequest('GET', $pathinfo, '', true);
    }
}
