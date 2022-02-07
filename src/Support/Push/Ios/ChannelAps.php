<?php

namespace luoyy\GtPush\Support\Push\Ios;

use JsonSerializable;
use luoyy\GtPush\Contracts\Support\Arrayable;
use luoyy\GtPush\Contracts\Support\Jsonable;
use luoyy\GtPush\Contracts\Support\Renderable;

class ChannelAps implements JsonSerializable, Arrayable, Renderable, Jsonable
{
    /**
     * 通知消息.
     * @var \luoyy\GtPush\Support\Push\Ios\ChannelApsAlert|null
     */
    protected $alert = null;

    /**
     * 0表示普通通知消息(默认为0)； 1表示静默推送(无通知栏消息)，静默推送时不需要填写其他参数。 苹果建议1小时最多推送3条静默消息.
     * @var int|null
     */
    protected $content_available = 0;

    /**
     * 通知铃声文件名，如果铃声文件未找到，响铃为系统默认铃声。 无声设置为“com.gexin.ios.silence”或不填.
     * @var string|null
     */
    protected $sound = null;

    /**
     * 在客户端通知栏触发特定的action和button显示.
     * @var string|null
     */
    protected $category = null;

    /**
     * ios的远程通知通过该属性对通知进行分组，仅支持iOS 12.0以上版本.
     * @var string|null
     */
    protected $thread_id = null;

    public function __construct(?ChannelApsAlert $alert = null, ?int $content_available = 0, ?string $sound = null, ?string $category = null, ?string $thread_id = null)
    {
        $this->alert = $alert;
        $this->content_available = $content_available;
        $this->sound = $sound;
        $this->category = $category;
        $this->thread_id = $thread_id;
    }

    public function setAlert(?ChannelApsAlert $alert = null)
    {
        $this->alert = $alert;
        return $this;
    }

    public function setContentAvailable(?int $content_available = 0)
    {
        $this->content_available = $content_available;
        return $this;
    }

    public function setSound(?string $sound = null)
    {
        $this->sound = $sound;
        return $this;
    }

    public function setCategory(?string $category = null)
    {
        $this->category = $category;
        return $this;
    }

    public function setThreadId(?string $thread_id = null)
    {
        $this->thread_id = $thread_id;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function toArray(): array: array
    {
        return array_filter([
            'alert' => !is_null($this->alert) ? $this->alert->toArray() : null,
            'content-available' => $this->content_available,
            'sound' => $this->sound,
            'category' => $this->category,
            'thread-id' => $this->thread_id,
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
