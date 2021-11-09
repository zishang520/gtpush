<?php

namespace luoyy\GtPush\Support;

use luoyy\GtPush\Contracts\Audience;
use luoyy\GtPush\Contracts\PushMessage;
use luoyy\GtPush\Support\Push\Message;

class PushObject extends PushMessage
{
    /**
     * 推送目标用户，详细解释见下方audience说明.
     * @var Audience
     */
    protected $audience;

    /**
     * 查询用户总量条件参数.
     * @copyright (c) zishang520 All Rights Reserved
     */
    public function __construct(string $request_id, Audience $audience, Message $push_message)
    {
        $this->request_id = $request_id;
        $this->audience = $audience;
        $this->push_message = $push_message;
    }

    public function setRequestId(string $request_id)
    {
        $this->request_id = $request_id;
        return $this;
    }

    public function setAudience(Audience $audience)
    {
        $this->audience = $audience;
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
            'audience' => $this->audience->toArray(),
            'push_message' => $this->push_message->toArray(),
            'settings' => !is_null($this->settings) ? ($this->settings->toArray() ?: null) : null,
            'push_channel' => !is_null($this->push_channel) ? ($this->push_channel->toArray() ?: null) : null,
        ], function ($v) {
            return !is_null($v);
        });
    }
}
