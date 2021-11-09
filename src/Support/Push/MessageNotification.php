<?php

namespace luoyy\GtPush\Support\Push;

use InvalidArgumentException;
use luoyy\GtPush\Contracts\MessageData;

class MessageNotification extends MessageData
{
    /**
     * 打开应用内特定页面.
     */
    public const INTENT = 'intent';

    /**
     * 打开网页地址.
     */
    public const URL = 'url';

    /**
     * 自定义消息内容启动应用.
     */
    public const PAYLOAD = 'payload';

    /**
     * 自定义消息内容不启动应用.
     */
    public const PAYLOAD_CUSTOM = 'payload_custom';

    /**
     * 打开应用首页.
     */
    public const STARTAPP = 'startapp';

    /**
     * 纯通知，无后续动作.
     */
    public const NONE = 'none';

    /**
     * 通知消息标题，长度 ≤ 50.
     * @var string
     */
    protected $title;

    /**
     * 通知消息内容，长度 ≤ 256.
     * @var string
     */
    protected $body;

    /**
     * 长文本消息内容，通知消息+长文本样式，与big_image二选一，两个都填写时报错，长度 ≤ 512.
     * @var string|null
     */
    protected $big_text = null;

    /**
     * 大图的URL地址，通知消息+大图样式， 与big_text二选一，两个都填写时报错，长度 ≤ 1024.
     * @var string|null
     */
    protected $big_image = null;

    /**
     * 通知的图标名称，包含后缀名（需要在客户端开发时嵌入），如“push.png”，长度 ≤ 64.
     * @var string|null
     */
    protected $logo = null;

    /**
     * 通知图标URL地址，长度 ≤ 256.
     * @var string|null
     */
    protected $logo_url = null;

    /**
     * 通知渠道id，长度 ≤ 64.
     * @var string|null
     */
    protected $channel_id = 'Default';

    /**
     * 通知渠道名称，长度 ≤ 64.
     * @var string|null
     */
    protected $channel_name = 'Default';

    /**
     * 设置通知渠道重要性（可以控制响铃，震动，浮动，闪灯等等） android8.0以下 0，1，2:无声音，无振动，不浮动 3:有声音，无振动，不浮动 4:有声音，有振动，有浮动 android8.0以上 0：无声音，无振动，不显示； 1：无声音，无振动，锁屏不显示，通知栏中被折叠显示，导航栏无logo; 2：无声音，无振动，锁屏和通知栏中都显示，通知不唤醒屏幕; 3：有声音，无振动，锁屏和通知栏中都显示，通知唤醒屏幕; 4：有声音，有振动，亮屏下通知悬浮展示，锁屏通知以默认形式展示且唤醒屏幕;.
     * @var int|null
     */
    protected $channel_level = 3;

    /**
     * 点击通知后续动作， 目前支持以下后续动作， intent：打开应用内特定页面， url：打开网页地址， payload：自定义消息内容启动应用， payload_custom：自定义消息内容不启动应用， startapp：打开应用首页， none：纯通知，无后续动作.
     * @var string
     */
    protected $click_type;

    /**
     * click_type为intent时必填 点击通知打开应用特定页面，长度 ≤ 4096; 示例：intent:#Intent;component=你的包名/你要打开的 activity 全路径;S.parm1=value1;S.parm2=value2;end intent生成请参考.
     * @var string|null
     */
    protected $intent = null;

    /**
     * click_type为url时必填 点击通知打开链接，长度 ≤ 1024.
     * @var string|null
     */
    protected $url = null;

    /**
     * click_type为payload/payload_custom时必填 点击通知加自定义消息，长度 ≤ 3072.
     * @var string|null
     */
    protected $payload = null;

    /**
     * 覆盖任务时会使用到该字段，两条消息的notify_id相同，新的消息会覆盖老的消息，范围：0-2147483647.
     * @var int|null
     */
    protected $notify_id = null;

    /**
     * 自定义铃声，请填写文件名，不包含后缀名(需要在客户端开发时嵌入)，个推通道下发有效 客户端SDK最低要求 2.14.0.0.
     * @var string|null
     */
    protected $ring_name = null;

    /**
     * 角标, 必须大于0, 个推通道下发有效 此属性目前仅针对华为 EMUI 4.1 及以上设备有效 角标数字数据会和之前角标数字进行叠加； 举例：角标数字配置1，应用之前角标数为2，发送此角标消息后，应用角标数显示为3。 客户端SDK最低要求 2.14.0.0.
     * @var int|null
     */
    protected $badge_add_num = null;

    /**
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $title 通知消息标题，长度 ≤ 50
     * @param string $body 通知消息内容，长度 ≤ 256
     * @param string $click_type 点击通知后续动作， 目前支持以下后续动作， intent：打开应用内特定页面， url：打开网页地址， payload：自定义消息内容启动应用， payload_custom：自定义消息内容不启动应用， startapp：打开应用首页， none：纯通知，无后续动作
     * @param string $next|null 后续的参数 click_type为intent点击通知打开应用特定页面，click_type为url时点击通知打开链接，click_type为payload/payload_custom时点击通知加自定义消息，长度 ≤ 3072
     */
    public function __construct(string $title, string $body, string $click_type, ?string $next)
    {
        $this->title = $title;
        $this->body = $body;
        $this->click_type = $click_type;
        switch ($this->click_type) {
            case self::INTENT:
                if (is_null($next)) {
                    throw new InvalidArgumentException(sprintf('Argument 4 passed to %s::__construct() must be of the type string, null given', __CLASS__));
                }
                $this->intent = $next;
                break;
            case self::URL:
                if (is_null($next)) {
                    throw new InvalidArgumentException(sprintf('Argument 4 passed to %s::__construct() must be of the type string, null given', __CLASS__));
                }
                $this->url = $next;
                break;
            case self::PAYLOAD:
            case self::PAYLOAD_CUSTOM:
                if (is_null($next)) {
                    throw new InvalidArgumentException(sprintf('Argument 4 passed to %s::__construct() must be of the type string, null given', __CLASS__));
                }
                $this->payload = $next;
                break;
        }
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    public function setBody(string $body)
    {
        $this->body = $body;
        return $this;
    }

    public function setBigText(?string $big_text = null)
    {
        $this->big_text = $big_text;
        return $this;
    }

    public function setBigImage(?string $big_image = null)
    {
        $this->big_image = $big_image;
        return $this;
    }

    public function setLogo(?string $logo = null)
    {
        $this->logo = $logo;
        return $this;
    }

    public function setLogoUrl(?string $logo_url = null)
    {
        $this->logo_url = $logo_url;
        return $this;
    }

    public function setChannelId(?string $channel_id = 'Default')
    {
        $this->channel_id = $channel_id;
        return $this;
    }

    public function setChannelName(?string $channel_name = 'Default')
    {
        $this->channel_name = $channel_name;
        return $this;
    }

    public function setChannelLevel(?int $channel_level = 3)
    {
        $this->channel_level = $channel_level;
        return $this;
    }

    public function setClickType(string $click_type)
    {
        $this->click_type = $click_type;
        return $this;
    }

    public function setIntent(?string $intent = null)
    {
        $this->intent = $intent;
        return $this;
    }

    public function setUrl(?string $url = null)
    {
        $this->url = $url;
        return $this;
    }

    public function setPayload(?string $payload = null)
    {
        $this->payload = $payload;
        return $this;
    }

    public function setNotifyId(?int $notify_id = null)
    {
        $this->notify_id = $notify_id;
        return $this;
    }

    public function setRingName(?string $ring_name = null)
    {
        $this->ring_name = $ring_name;
        return $this;
    }

    public function setBadgeAddNum(?int $badge_add_num = null)
    {
        $this->badge_add_num = $badge_add_num;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function data(): array
    {
        return [
            'notification' => array_filter([
                'title' => $this->title,
                'body' => $this->body,
                'big_text' => $this->big_text,
                'big_image' => $this->big_image,
                'logo' => $this->logo,
                'logo_url' => $this->logo_url,
                'channel_id' => $this->channel_id,
                'channel_name' => $this->channel_name,
                'channel_level' => $this->channel_level,
                'click_type' => $this->click_type,
                'intent' => $this->intent,
                'url' => $this->url,
                'payload' => $this->payload,
                'notify_id' => $this->notify_id,
                'ring_name' => $this->ring_name,
                'badge_add_num' => $this->badge_add_num,
            ], function ($v) {
                return !is_null($v);
            }),
        ];
    }
}
