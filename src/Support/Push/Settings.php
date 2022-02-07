<?php

namespace luoyy\GtPush\Support\Push;

use JsonSerializable;
use luoyy\GtPush\Contracts\Support\Arrayable;
use luoyy\GtPush\Contracts\Support\Jsonable;
use luoyy\GtPush\Contracts\Support\Renderable;

class Settings implements JsonSerializable, Arrayable, Renderable, Jsonable
{
    /**
     * 消息离线时间设置，单位毫秒，-1表示不设离线，-1 ～ 3 * 24 * 3600 * 1000(3天)之间.
     * @var int|null
     */
    protected $ttl = null;

    /**
     * 厂商通道策略，详细内容见strategy.
     * @see https://docs.getui.com/getui/server/rest_v2/common_args/?id=doc-title-5
     * @var array|null
     */
    protected $strategy = null;

    /**
     * 定速推送，例如100，个推控制下发速度在100条/秒左右，0表示不限速.
     * @var int|null
     */
    protected $speed = 0;

    /**
     * 定时推送时间，格式：毫秒时间戳，此功能需要开通VIP，如需开通请点击右侧“技术咨询”了解详情.
     * @var int|null
     */
    protected $schedule_time = null;

    /**
     * 查询用户总量条件参数.
     * @copyright (c) zishang520 All Rights Reserved
     * @param int|null $ttl 消息离线时间设置，单位毫秒，-1表示不设离线，-1 ～ 3 * 24 * 3600 * 1000(3天)之间
     * @param array|null $strategy 厂商通道策略，详细内容见strategy {"default":1}
     * @param int|null $speed 定速推送，例如100，个推控制下发速度在100条/秒左右，0表示不限速
     * @param int|null $schedule_time 定时推送时间，格式：毫秒时间戳，此功能需要开通VIP，如需开通请点击右侧“技术咨询”了解详情
     */
    public function __construct(?int $ttl = null, ?array $strategy = null, ?int $speed = null, ?int $schedule_time = null)
    {
        $this->ttl = $ttl;
        $this->strategy = $strategy;
        $this->speed = $speed;
        $this->schedule_time = $schedule_time;
    }

    public function setTtl(?int $ttl = null)
    {
        $this->ttl = $ttl;
        return $this;
    }

    public function setStrategy(?array $strategy = null)
    {
        $this->strategy = $strategy;
        return $this;
    }

    public function setSpeed(?int $speed = 0)
    {
        $this->speed = $speed;
        return $this;
    }

    public function setScheduleTime(?int $schedule_time = null)
    {
        $this->schedule_time = $schedule_time;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function toArray(): array: array
    {
        return array_filter([
            'ttl' => $this->ttl,
            'strategy' => $this->strategy,
            'speed' => $this->speed,
            'schedule_time' => $this->schedule_time,
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
