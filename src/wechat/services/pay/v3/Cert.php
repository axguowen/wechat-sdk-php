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

use axguowen\wechat\utils\crypt\PayCryptor;

/**
 * 平台证书管理
 */
class Cert extends BasicWePay
{
    /**
     * 商户平台下载证书
     * @access public
     * @return void
     * @throws \axguowen\wechat\exception\InvalidResponseException
     */
    public function download()
    {
        try {
            $aes = new PayCryptor($this->config['mch_v3_key']);
            $result = $this->doRequest('GET', '/v3/certificates');
            foreach ($result['data'] as $vo) {
                $this->tmpFile($vo['serial_no'], $aes->decryptToString(
                    $vo['encrypt_certificate']['associated_data'],
                    $vo['encrypt_certificate']['nonce'],
                    $vo['encrypt_certificate']['ciphertext']
                ));
            }
        } catch (\Exception $exception) {
            throw new \axguowen\wechat\exception\InvalidResponseException($exception->getMessage(), $exception->getCode());
        }
    }
}