<?php

namespace luoyy\GtPush\Support\Push\Android;

use InvalidArgumentException;

class MessageNotification extends MessageData
{
    /**
     * 打开应用内特定页面.
     */
    public const INTENT = 'intent';

    /**
     * 打开网页地址.
     */
    public const URL = 'url';

    /**
     * 打开应用首页.
     */
    public const STARTAPP = 'startapp';

    /**
     * 通知栏标题（长度建议取最小集） 小米：title长度限制为50字 华为：title长度限制40字 魅族：title长度限制32字 OPPO：title长度限制32字 VIVO：title长度限制40英文字符.
     * @var string
     */
    protected $title;

    /**
     * 通知栏内容(长度建议取最小集) 小米：content长度限制128字 华为：content长度小于1024字 魅族：content长度限制100字 OPPO：content长度限制200字 VIVO：content长度限制100个英文字符.
     * @var string
     */
    protected $body;

    /**
     * 点击通知后续动作, 目前支持以下后续动作， intent：打开应用内特定页面(厂商都支持)， url：打开网页地址(厂商都支持，华为要求https协议)， startapp：打开应用首页(厂商都支持).
     * @var string
     */
    protected $click_type;

    /**
     * click_type为intent时必填 点击通知打开应用特定页面，长度 ≤ 4096; 示例：intent:#Intent;component=你的包名/你要打开的 activity 全路径;S.parm1=value1;S.parm2=value2;end intent生成请参考.
     * @var string|null
     */
    protected $intent = null;

    /**
     * click_type为url时必填 点击通知打开链接，长度 ≤ 1024.
     * @var string|null
     */
    protected $url = null;

    /**
     * 覆盖任务时会使用到该字段，两条消息的notify_id相同，新的消息会覆盖老的消息，范围：0-2147483647.
     * @var int|null
     */
    protected $notify_id = null;

    /**
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $title 通知栏标题（长度建议取最小集） 小米：title长度限制为50字 华为：title长度限制40字 魅族：title长度限制32字 OPPO：title长度限制32字 VIVO：title长度限制40英文字符
     * @param string $body 通知栏内容(长度建议取最小集) 小米：content长度限制128字 华为：content长度小于1024字 魅族：content长度限制100字 OPPO：content长度限制200字 VIVO：content长度限制100个英文字符
     * @param string $click_type 点击通知后续动作, 目前支持以下后续动作， intent：打开应用内特定页面(厂商都支持)， url：打开网页地址(厂商都支持，华为要求https协议)， startapp：打开应用首页(厂商都支持)
     * @param string $next|null 后续的参数 click_type为intent点击通知打开应用特定页面，click_type为url时点击通知打开链接，click_type为payload/payload_custom时点击通知加自定义消息，长度 ≤ 3072
     */
    public function __construct(string $title, string $body, string $click_type, ?string $next)
    {
        $this->title = $title;
        $this->body = $body;
        $this->click_type = $click_type;

        switch ($this->click_type) {
            case self::INTENT:
                if (is_null($next)) {
                    throw new InvalidArgumentException(sprintf('Argument 4 passed to %s::__construct() must be of the type string, null given', __CLASS__));
                }
                $this->intent = $next;
                break;
            case self::URL:
                if (is_null($next)) {
                    throw new InvalidArgumentException(sprintf('Argument 4 passed to %s::__construct() must be of the type string, null given', __CLASS__));
                }
                $this->url = $next;
                break;
        }
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    public function setBody(string $body)
    {
        $this->body = $body;
        return $this;
    }

    public function setClickType(string $click_type)
    {
        $this->click_type = $click_type;
        return $this;
    }

    public function setIntent(?string $intent = null)
    {
        $this->intent = $intent;
        return $this;
    }

    public function setUrl(?string $url = null)
    {
        $this->url = $url;
        return $this;
    }

    public function setNotifyId(?int $notify_id = null)
    {
        $this->notify_id = $notify_id;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function data(): array
    {
        return [
            'notification' => array_filter([
                'title' => $this->title,
                'body' => $this->body,
                'click_type' => $this->click_type,
                'intent' => $this->intent,
                'url' => $this->url,
                'notify_id' => $this->notify_id,
            ], function ($v) {
                return !is_null($v);
            }),
        ];
    }
}
