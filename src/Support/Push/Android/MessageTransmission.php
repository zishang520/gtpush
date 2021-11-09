<?php

namespace luoyy\GtPush\Support\Push\Android;

class MessageTransmission extends MessageData
{
    /**
     * 纯透传消息内容，安卓和iOS均支持，与notification、revoke 三选一，都填写时报错，长度 ≤ 3072.
     * @var string
     */
    protected $body;

    /**
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $body 纯透传消息内容，安卓和iOS均支持，与notification、revoke 三选一，都填写时报错，长度 ≤ 3072
     */
    public function __construct(string $body)
    {
        $this->body = $body;
    }

    public function setBody(string $body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function data(): array
    {
        return [
            'transmission' => $this->body,
        ];
    }
}
