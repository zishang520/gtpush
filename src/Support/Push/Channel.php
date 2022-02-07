<?php

namespace luoyy\GtPush\Support\Push;

use JsonSerializable;
use luoyy\GtPush\Contracts\ChannelData;
use luoyy\GtPush\Contracts\Support\Arrayable;
use luoyy\GtPush\Contracts\Support\Jsonable;
use luoyy\GtPush\Contracts\Support\Renderable;

class Channel implements JsonSerializable, Arrayable, Renderable, Jsonable
{
    /**
     * 厂商通道消息内容.
     * @var ChannelData[]
     */
    protected $channels = [];

    public function __construct(ChannelData ...$channels)
    {
        $this->setChannels(...$channels);
    }

    public function setChannels(ChannelData ...$channels)
    {
        $this->channels = [];
        foreach ($channels as $channel) {
            $this->channels[$channel->type()] = $channel->toArray();
        }
        return $this;
    }

    public function addChannels(ChannelData ...$channels)
    {
        foreach ($channels as $channel) {
            $this->channels[$channel->type()] = $channel->toArray();
        }

        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->channels;
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
