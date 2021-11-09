<?php

namespace luoyy\GtPush\Support;

use luoyy\GtPush\Contracts\PushMessage;
use luoyy\GtPush\Support\Push\Message;

class CreatePushObject extends PushMessage
{
    /**
     * 查询用户总量条件参数.
     * @copyright (c) zishang520 All Rights Reserved
     */
    public function __construct(Message $push_message)
    {
        $this->push_message = $push_message;
    }

    public function setRequestId(?string $request_id = null)
    {
        $this->request_id = $request_id;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function data(): array
    {
        return array_filter([
            'request_id' => $this->request_id,
            'group_name' => $this->group_name,
            'push_message' => $this->push_message->toArray(),
            'settings' => !is_null($this->settings) ? ($this->settings->toArray() ?: null) : null,
            'push_channel' => !is_null($this->push_channel) ? ($this->push_channel->toArray() ?: null) : null,
        ], function ($v) {
            return !is_null($v);
        });
    }
}
