<?php

namespace luoyy\GtPush;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use League\Flysystem\Config;
use Throwable;

/**
 * Push REST API.
 */
class Push
{
    // GtPush https接口参数, 一般不需要修改
    public const API_URL = 'https://restapi.getui.com';

    public const VER = 'v2';

    // app基本信息
    protected $config = null;

    protected $errMsg = '';

    protected $errCode = 0;

    protected $token = null;

    protected $cache_key = null;

    protected $cache_class = \Illuminate\Support\Facades\Cache::class;

    public function __construct(array $options = [])
    {
        $this->config = new Config($options);
        $this->cache_key = $this->config->get('token_cache_name', 'GT-PUSH-TOKEN');
        $this->cache_class = $this->config->get('cache_class', $this->cache_class);
    }

    /**
     * 获取错误信息.
     * @copyright (c) zishang520 All Rights Reserved
     * @return mixed [错误内容]
     */
    public function errMsg()
    {
        try {
            return $this->errMsg;
        } finally {
            // 防止重复使用
            $this->errMsg = '';
        }
    }

    /**
     * 获取错误Code.
     * @copyright (c) zishang520 All Rights Reserved
     * @return mixed [code值]
     */
    public function errCode()
    {
        try {
            return $this->errCode;
        } finally {
            // 防止重复使用
            $this->errCode = 0;
        }
    }

    /**
     * 获取授权的token.
     * 注：鉴权接口每分钟最大调用量为100次，每天最大调用量为10万次，建议开发者妥善管理token，以免达到限制，影响推送
     * @see https://docs.getui.com/getui/server/rest_v2/token/#doc-title-0
     * @copyright (c) zishang520 All Rights Reserved
     */
    public function auth()
    {
        $timeStamp = (string) Carbon::now()->getTimestampMs();
        return $this->request('POST', 'auth', [
            'sign' => hash('sha256', $this->config->get('appkey') . $timeStamp . $this->config->get('master_secret')),
            'timestamp' => $timeStamp,
            'appkey' => $this->config->get('appkey'),
        ]);
    }

    /**
     * 删除授权的token.
     * 为防止token被滥用或泄露，开发者可以调用此接口主动使token失效.
     * @see https://docs.getui.com/getui/server/rest_v2/token/#doc-title-1
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $token 已经授权的token，默认为当前缓存的token
     */
    public function delete_auth(?string $token = null)
    {
        if (is_null($this->request('DELETE', sprintf('auth/%s', $token ?? $this->token)))) {
            if (is_null($token)) {
                $this->token = null;
                call_user_func([$this->cache_class, 'forget'], $this->cache_key);
            }
            return true;
        }
        return false;
    }

    /**
     * 获取token.
     * @copyright (c) zishang520 All Rights Reserved
     * @param bool $force 强制刷新token
     */
    public function getToken(bool $force = false): string
    {
        if (!$force) {
            if (!is_null($this->token)) {
                return $this->token;
            }
            if (!is_null($this->token = call_user_func([$this->cache_class, 'get'], $this->cache_key))) {
                return $this->token;
            }
        }
        if (!empty($auth = $this->auth())) {
            $this->token = $auth->token;
            call_user_func([$this->cache_class, 'put'], $this->cache_key, $auth->token, Carbon::createFromTimestampMs($auth->expire_time)->subHours(5));
            return $this->token;
        }
        throw new \RuntimeException(sprintf('Get token fail: %s.', $this->errMsg() ?: 'Request failed'), $this->errCode());
    }

    /**
     * API接口基础方法.
     * @copyright (c) zishang520 All Rights Reserved
     */
    public function api(string $method, string $command, array $data = [])
    {
        // 如果token失效，重试
        if (($data = $this->request($method, $command, array_filter($data, function ($v) {
            return !is_null($v);
        }), ['Token' => $this->getToken()])) === false) {
            if (((int) $this->errCode) === 10001) {
                $data = $this->request($method, $command, array_filter($data, function ($v) {
                    return !is_null($v);
                }), ['Token' => $this->getToken(true)]);
            }
        }
        return $data;
    }

    /**
     * Header.
     * @copyright (c) zishang520 All Rights Reserved
     */
    protected function _header(): array
    {
        return [
            'Pragma' => 'no-cache',
            'Cache-Control' => 'no-cache',
            'Upgrade-Insecure-Requests' => '1',
            'Dnt' => '1',
            'Accept-Encoding' => 'gzip, deflate',
            'User-Agent' => 'GeTui RAS2 PHP/1.0',
        ];
    }

    /**
     * APi.
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $method 请求方法
     * @param string $command 命令字
     * @param array $opts 请求的一些设置
     * @return mixed
     */
    protected function request(string $method, string $command, array $data = [], array $header = [])
    {
        try {
            $opts = [
                'headers' => $this->_header() + $header,
            ];
            if (!empty($data)) {
                $opts['json'] = $data;
            }
            $_data = (string) (new Client())->request($method, sprintf('%s/%s/%s/%s', self::API_URL, self::VER, $this->config->get('appid'), ltrim($command, '/')), $opts)->getBody();
            if (!empty($_data) && !empty($body = json_decode($_data))) {
                if (!empty($body->code)) {
                    $this->errMsg = $body->msg ?? '请求失败';
                    $this->errCode = $body->code ?? -1;
                    return false;
                }
                return $body->data ?? null;
            }
            $this->errMsg = '请求失败';
            $this->errCode = -1;
            return false;
        } catch (ClientException $e) {
            if ($e->hasResponse() && !empty($body = json_decode((string) $e->getResponse()->getBody()))) {
                $this->errMsg = $body->msg ?? '请求失败';
                $this->errCode = $body->code ?? -1;
                return false;
            }
            $this->errMsg = '请求失败';
            $this->errCode = -1;
            return false;
        } catch (Throwable $e) {
            $this->errMsg = $e->getMessage();
            $this->errCode = $e->getCode();
            return false;
        }
    }
}
