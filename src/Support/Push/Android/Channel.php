<?php

namespace luoyy\GtPush\Support\Push\Android;

use luoyy\GtPush\Contracts\ChannelData;

class Channel extends ChannelData
{
    /**
     * 推送通知消息内容.
     * @var \luoyy\GtPush\Support\Push\ChannelAndroidUps|null
     */
    protected $ups = null;

    public function __construct(?ChannelUps $ups = null)
    {
        $this->ups = $ups;
    }

    public function setUps(?ChannelUps $ups = null)
    {
        $this->ups = $ups;
        return $this;
    }

    public function type(): string
    {
        return 'android';
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function data(): array
    {
        return [
            'ups' => !is_null($this->ups) ? ($this->ups->toArray() ?: null) : null,
        ];
    }
}
