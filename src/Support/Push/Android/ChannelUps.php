<?php

namespace luoyy\GtPush\Support\Push\Android;

use JsonSerializable;
use luoyy\GtPush\Contracts\Support\Arrayable;
use luoyy\GtPush\Contracts\Support\Jsonable;
use luoyy\GtPush\Contracts\Support\Renderable;

class ChannelUps implements JsonSerializable, Arrayable, Renderable, Jsonable
{
    /**
     * 第三方厂商扩展内容.
     * @var array|null
     */
    protected $options = null;

    /**
     * MessageNotification、MessageTransmission、MessageRevoke三选一
     * @var \luoyy\GtPush\Support\Push\Android\MessageData|null
     */
    protected $message = null;

    /**
     * @copyright (c) zishang520 All Rights Reserved
     * @param \luoyy\GtPush\Support\Push\Android\MessageData|null $message 通知消息内容|纯透传消息内容|撤回消息时使用
     * @param string|null $duration 手机端通知展示时间段，格式为毫秒时间戳段，两个时间的时间差必须大于10分钟，例如："1590547347000-1590633747000"
     */
    public function __construct(?MessageData $message = null, ?array $options = null)
    {
        $this->options = $options;
        $this->message = $message;
    }

    public function setOptions(?array $options = null)
    {
        $this->options = $options;
        return $this;
    }

    public function setMessage(?MessageData $message = null)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'options' => $this->options,
        ] + (!is_null($this->message) ? $this->message->toArray() : []), function ($v) {
            return !is_null($v);
        });
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function render()
    {
        return $this->toJson();
    }

    /**
     * Convert the fluent instance to JSON.
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
