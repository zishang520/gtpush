<?php

namespace luoyy\GtPush\Support\Push\Ios;

use JsonSerializable;
use luoyy\GtPush\Contracts\Support\Arrayable;
use luoyy\GtPush\Contracts\Support\Jsonable;
use luoyy\GtPush\Contracts\Support\Renderable;

class ChannelMultimedia implements JsonSerializable, Arrayable, Renderable, Jsonable
{
    /**
     * 多媒体资源地址.
     * @var string
     */
    protected $url;

    /**
     *  资源类型（1.图片，2.音频，3.视频）.
     * @var int
     */
    protected $type;

    /**
     * 是否只在wifi环境下加载，如果设置成true,但未使用wifi时，会展示成普通通知.
     * @var bool|null
     */
    protected $only_wifi = false;

    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    public function setType(int $type)
    {
        $this->type = $type;
        return $this;
    }

    public function setOnlyWifi(?bool $only_wifi = false)
    {
        $this->only_wifi = $only_wifi;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function toArray(): array: array
    {
        return array_filter([
            'url' => $this->url,
            'type' => $this->type,
            'only_wifi' => $this->only_wifi,
        ], function ($v) {
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
