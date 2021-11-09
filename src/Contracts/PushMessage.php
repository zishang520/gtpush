<?php

namespace luoyy\GtPush\Contracts;

use JsonSerializable;
use luoyy\GtPush\Contracts\Support\Arrayable;
use luoyy\GtPush\Contracts\Support\Jsonable;
use luoyy\GtPush\Contracts\Support\Renderable;
use luoyy\GtPush\Support\Push\Channel;
use luoyy\GtPush\Support\Push\Message;
use luoyy\GtPush\Support\Push\Settings;

abstract class PushMessage implements JsonSerializable, Arrayable, Renderable, Jsonable
{
    /**
     * 请求唯一标识号，10-32位之间；如果request_id重复，会导致消息丢失.
     * @var string|null
     */
    protected $request_id = null;

    /**
     * 推送条件设置，详细解释见下方settings说明.
     * @var Settings|null
     */
    protected $settings = null;

    /**
     * 个推推送消息参数，详细内容见push_message.
     * @see https://docs.getui.com/getui/server/rest_v2/common_args/?id=doc-title-6
     * @var Message
     */
    protected $push_message;

    /**
     * 厂商推送消息参数，包含ios消息参数，android厂商消息参数，详细内容见push_channel.
     * @see https://docs.getui.com/getui/server/rest_v2/common_args/?id=doc-title-7
     * @var Channel|null
     */
    protected $push_channel = null;

    /**
     * 任务组名.
     * @var string|null
     */
    protected $group_name = null;

    abstract public function data(): array;

    public function setSettings(?Settings $settings = null)
    {
        $this->settings = $settings;
        return $this;
    }

    public function setPushMessage(Message $push_message)
    {
        $this->push_message = $push_message;
        return $this;
    }

    public function setPushChannel(?Channel $push_channel = null)
    {
        $this->push_channel = $push_channel;
        return $this;
    }

    public function setGroupName(?string $group_name = null)
    {
        $this->group_name = $group_name;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->data();
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
