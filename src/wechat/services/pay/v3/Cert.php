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
use axguowen\wechat\exception\InvalidResponseException;
/**
 * 平台证书管理
 */
class Cert extends BasicWePay
{
    /**
     * 自动配置平台证书
     * @var bool
     */
    protected $autoCert = false;

    /**
     * 商户平台下载证书
     * @access public
     * @return void
     * @throws InvalidResponseException
     */
    public function download()
    {
        try {
            $aes = new PayCryptor($this->config['mch_v3_key']);
            $result = $this->doRequest('GET', '/v3/certificates');
            $certs = [];
            foreach ($result['data'] as $vo) {
                $certs[$vo['serial_no']] = [
                    'expire'  => strtotime($vo['expire_time']),
                    'content' => $aes->decryptToString(
                        $vo['encrypt_certificate']['associated_data'],
                        $vo['encrypt_certificate']['nonce'],
                        $vo['encrypt_certificate']['ciphertext']
                    )
                ];
            }
            $this->tmpFile("{$this->config['mch_id']}_certs", $certs);
        } catch (\Exception $exception) {
            throw new InvalidResponseException($exception->getMessage(), $exception->getCode());
        }
    }
}