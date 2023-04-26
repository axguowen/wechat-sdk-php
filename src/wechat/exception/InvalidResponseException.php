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

namespace axguowen\wechat\exception;

/**
 * 返回异常
 */
class InvalidResponseException extends \Exception
{
    /**
     * @var array
     */
    public $raw = [];

    /**
     * 构造方法
     * @access public
     * @param string $message
     * @param integer $code
     * @param array $raw
     * @return void
     */
    public function __construct($message, $code = 0, $raw = [])
    {
        parent::__construct($message, intval($code));
        $this->raw = $raw;
    }

}