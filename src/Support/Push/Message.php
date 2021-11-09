<?php

namespace luoyy\GtPush\Support\Push;

use JsonSerializable;
use luoyy\GtPush\Contracts\MessageData;
use luoyy\GtPush\Contracts\Support\Arrayable;
use luoyy\GtPush\Contracts\Support\Jsonable;
use luoyy\GtPush\Contracts\Support\Renderable;

class Message implements JsonSerializable, Arrayable, Renderable, Jsonable
{
    /**
     * 手机端通知展示时间段，格式为毫秒时间戳段，两个时间的时间差必须大于10分钟，例如："1590547347000-1590633747000".
     * @var string|null
     */
    protected $duration = null;

    /**
     * MessageNotification、MessageTransmission、MessageRevoke三选一
     * @var \luoyy\GtPush\Contracts\MessageData|null
     */
    protected $message = null;

    /**
     * @copyright (c) zishang520 All Rights Reserved
     * @param string|null $duration 手机端通知展示时间段，格式为毫秒时间戳段，两个时间的时间差必须大于10分钟，例如："1590547347000-1590633747000"
     * @param \luoyy\GtPush\Contracts\MessageData|null $message 通知消息内容|纯透传消息内容|撤回消息时使用
     */
    public function __construct(?string $duration = null, ?MessageData $message = null)
    {
        $this->duration = $duration;
        $this->message = $message;
    }

    public function setDuration(?string $duration = null)
    {
        $this->duration = $duration;
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
    public function toArray()
    {
        return array_filter([
            'duration' => $this->duration,
        ] + (!is_null($this->message) ? $this->message->toArray() : []), function ($v) {
            return !is_null($v);
        });
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
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
