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

namespace axguowen;

use axguowen\wechat\utils\DataArray;
use axguowen\wechat\utils\Tools;
use axguowen\wechat\exception\InvalidArgumentException;
use axguowen\wechat\exception\InvalidResponseException;

/**
 * 微信SDK基础类
 */
class WeChat
{

    /**
     * 当前配置对象
     * @var DataArray
     */
    public $config;

    /**
     * 访问AccessToken
     * @var string
     */
    public $accessToken = '';

    /**
     * 当前请求方法参数
     * @var array
     */
    protected $currentMethod = [];

    /**
     * 当前模式
     * @var bool
     */
    protected $isTry = false;

    /**
     * 静态缓存
     * @var static
     */
    protected static $cache;

    /**
     * 注册代替函数
     * @var string
     */
    protected $getAccessTokenCallback;

    /**
     * 构造方法
     * @access public
     * @param array $options 配置参数
     * @return void
     * @throws InvalidArgumentException
     */
    public function __construct(array $options)
    {
        // 缺少appid
        if (empty($options['appid'])) {
            throw new InvalidArgumentException("Missing Config -- [appid]");
        }
        // 缺少appsecret
        if (empty($options['appsecret'])) {
            throw new InvalidArgumentException("Missing Config -- [appsecret]");
        }
        if (isset($options['get_access_token_callback']) && is_callable($options['get_access_token_callback'])) {
            $this->getAccessTokenCallback = $options['get_access_token_callback'];
        }
        if (!empty($options['cache_path'])) {
            Tools::$cache_path = $options['cache_path'];
        }
        // 实例化配置对象
        $this->config = new DataArray($options);
    }

    /**
     * 静态创建对象
     * @access public
     * @param array $config 配置参数
     * @return static
     */
    public static function instance(array $config)
    {
        // 构造缓存键
        $key = md5(get_called_class() . serialize($config));
        // 从缓存获取
        if (isset(self::$cache[$key])){
            return self::$cache[$key];
        }
        return self::$cache[$key] = new static($config);
    }

    /**
     * 获取AccessToken
     * @access public
     * @return string
     */
    public function getAccessToken()
    {
        // 当前已存在
        if (!empty($this->accessToken)) {
            return $this->accessToken;
        }
        // 构造缓存键
        $cache_key = $this->config->get('appid') . '_access_token';
        // 从缓存获取
        $this->accessToken = Tools::getCache($cache_key);
        if (!empty($this->accessToken)) {
            return $this->accessToken;
        }
        // 处理开放平台授权公众号获取AccessToken
        if (!empty($this->getAccessTokenCallback) && is_callable($this->getAccessTokenCallback)) {
            $this->accessToken = call_user_func_array($this->getAccessTokenCallback, [$this->config->get('appid'), $this]);
            if (!empty($this->accessToken)) {
                Tools::setCache($cache_key, $this->accessToken, 7000);
            }
            return $this->accessToken;
        }
        // 通过接口获取
        list($appid, $secret) = [$this->config->get('appid'), $this->config->get('appsecret')];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
        $result = Tools::json2arr(Tools::get($url));
        if (!empty($result['access_token'])) {
            Tools::setCache($cache_key, $result['access_token'], 7000);
        }
        return $this->accessToken = $result['access_token'];
    }

    /**
     * 设置AccessToken
     * @access public
     * @param string $accessToken AccessToken
     * @return void
     * @throws InvalidArgumentException
     *
     * 当用户使用自己的缓存驱动时，直接实例化对象后可直接设置 AccessToken
     * 多用于分布式项目时保持 AccessToken 统一
     * 使用此方法后就由用户来保证传入的 AccessToken 有效
     */
    public function setAccessToken($accessToken)
    {
        if (!is_string($accessToken)) {
            throw new InvalidArgumentException("Invalid AccessToken type, need string.");
        }
        $cache = $this->config->get('appid') . '_access_token';
        Tools::setCache($cache, $this->accessToken = $accessToken);
    }

    /**
     * 删除AccessToken
     * @access public
     * @return bool
     */
    public function delAccessToken()
    {
        $this->accessToken = '';
        return Tools::delCache($this->config->get('appid') . '_access_token');
    }

    /**
     * 以GET获取接口数据并转为数组
     * @access protected
     * @param string $url 接口地址
     * @return array
     * @throws InvalidResponseException
     */
    protected function httpGetForJson($url)
    {
        try {
            return Tools::json2arr(Tools::get($url));
        } catch (InvalidResponseException $exception) {
            if (isset($this->currentMethod['method']) && empty($this->isTry)) {
                if (in_array($exception->getCode(), ['40014', '40001', '41001', '42001'])) {
                    [$this->delAccessToken(), $this->isTry = true];
                    return call_user_func_array([$this, $this->currentMethod['method']], $this->currentMethod['arguments']);
                }
            }
            throw new InvalidResponseException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * 以POST获取接口数据并转为数组
     * @access protected
     * @param string $url 接口地址
     * @param array $data 请求数据
     * @param bool $buildToJson
     * @return array
     * @throws InvalidResponseException
     */
    protected function httpPostForJson($url, array $data, $buildToJson = true)
    {
        try {
            $options = [];
            if ($buildToJson) $options['headers'] = ['Content-Type: application/json'];
            return Tools::json2arr(Tools::post($url, $buildToJson ? Tools::arr2json($data) : $data, $options));
        } catch (InvalidResponseException $exception) {
            if (!$this->isTry && in_array($exception->getCode(), ['40014', '40001', '41001', '42001'])) {
                [$this->delAccessToken(), $this->isTry = true];
                return call_user_func_array([$this, $this->currentMethod['method']], $this->currentMethod['arguments']);
            }
            throw new InvalidResponseException($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * 注册当前请求接口
     * @access protected
     * @param string $url 接口地址
     * @param string $method 当前接口方法
     * @param array $arguments 请求参数
     * @return string
     */
    protected function registerApi(&$url, $method, $arguments = [])
    {
        $this->currentMethod = ['method' => $method, 'arguments' => $arguments];
        if (empty($this->accessToken)) $this->accessToken = $this->getAccessToken();
        return $url = str_replace('ACCESS_TOKEN', urlencode($this->accessToken), $url);
    }

    /**
     * 接口通用POST请求方法
     * @access public
     * @param string $url 接口URL
     * @param array $data POST提交接口参数
     * @param bool $isBuildJson
     * @return array
     */
    public function callPostApi($url, array $data, $isBuildJson = true)
    {
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpPostForJson($url, $data, $isBuildJson);
    }

    /**
     * 接口通用GET请求方法
     * @access public
     * @param string $url 接口URL
     * @return array
     */
    public function callGetApi($url)
    {
        $this->registerApi($url, __FUNCTION__, func_get_args());
        return $this->httpGetForJson($url);
    }

}