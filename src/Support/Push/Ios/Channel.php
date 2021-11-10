<?php

namespace luoyy\GtPush\Support\Push\Ios;

use luoyy\GtPush\Contracts\ChannelData;

class Channel extends ChannelData
{
    /**
     * voip：voip语音推送，notify：apns通知消息.
     * @var string|null
     */
    protected $type = 'notify';

    /**
     * 推送通知消息内容.
     * @var \luoyy\GtPush\Support\Push\Ios\ChannelAps|null
     */
    protected $aps = null;

    /**
     * 用于计算icon上显示的数字，还可以实现显示数字的自动增减，如“+1”、 “-1”、 “1” 等，计算结果将覆盖badge.
     * @var string|null
     */
    protected $auto_badge = null;

    /**
     * 增加自定义的数据.
     * @var string|null
     */
    protected $payload = null;

    /**
     * 多媒体设置.
     * @var \luoyy\GtPush\Support\Push\Ios\ChannelMultimedia[]|null
     */
    protected $multimedia = null;

    /**
     * 使用相同的apns-collapse-id可以覆盖之前的消息.
     * @var string|null
     */
    protected $apns_collapse_id = null;

    public function __construct(?string $type = 'notify', ?ChannelAps $aps = null, ?string $auto_badge = null)
    {
        $this->type = $type;
        $this->aps = $aps;
        $this->auto_badge = $auto_badge;
    }

    public function setType(?string $type = 'notify')
    {
        $this->type = $type;
        return $this;
    }

    public function setAps(?ChannelAps $aps = null)
    {
        $this->aps = $aps;
        return $this;
    }

    public function setAutoBadge(?string $auto_badge = null)
    {
        $this->auto_badge = $auto_badge;
        return $this;
    }

    public function setPayload(?string $payload = null)
    {
        $this->payload = $payload;
        return $this;
    }

    public function setMultimedia(?ChannelMultimedia ...$multimedia)
    {
        $this->multimedia = $multimedia ?: null;
        return $this;
    }

    public function setApnsCollapseId(?string $apns_collapse_id = null)
    {
        $this->apns_collapse_id = $apns_collapse_id;
        return $this;
    }

    public function type(): string
    {
        return 'ios';
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function data(): array
    {
        return array_filter([
            'type' => $this->type,
            'aps' => !is_null($this->aps) ? ($this->aps->toArray() ?: null) : null,
            'auto_badge' => $this->auto_badge,
            'payload' => $this->payload,
            'multimedia' => !is_null($this->multimedia) ? (array_map(function ($multimedia) {
                return $multimedia->toArray();
            }, $this->multimedia) ?: null) : null,
            'apns_collapse_id' => $this->apns_collapse_id,
        ], function ($v) {
            return !is_null($v);
        });
    }
}
