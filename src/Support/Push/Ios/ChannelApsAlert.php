<?php

namespace luoyy\GtPush\Support\Push\Ios;

use JsonSerializable;
use luoyy\GtPush\Contracts\Support\Arrayable;
use luoyy\GtPush\Contracts\Support\Jsonable;
use luoyy\GtPush\Contracts\Support\Renderable;

class ChannelApsAlert implements JsonSerializable, Arrayable, Renderable, Jsonable
{
    /**
     * 通知消息标题.
     * @var string|null
     */
    protected $title = null;

    /**
     * 通知消息内容.
     * @var string|null
     */
    protected $body = null;

    /**
     * （用于多语言支持）指定执行按钮所使用的Localizable.strings.
     * @var string|null
     */
    protected $action_loc_key = null;

    /**
     * （用于多语言支持）指定Localizable.strings文件中相应的key.
     * @var string|null
     */
    protected $loc_key = null;

    /**
     * 如果loc-key中使用了占位符，则在loc-args中指定各参数.
     * @var array|null
     */
    protected $loc_args = null;

    /**
     * 指定启动界面图片名.
     * @var string|null
     */
    protected $launch_image = null;

    /**
     * (用于多语言支持）对于标题指定执行按钮所使用的Localizable.strings,仅支持iOS8.2以上版本.
     * @var string|null
     */
    protected $title_loc_key = null;

    /**
     * 对于标题,如果loc-key中使用的占位符，则在loc-args中指定各参数,仅支持iOS8.2以上版本.
     * @var array|null
     */
    protected $title_loc_args = null;

    /**
     * 通知子标题,仅支持iOS8.2以上版本.
     * @var string|null
     */
    protected $subtitle = null;

    /**
     * 当前本地化文件中的子标题字符串的关键字,仅支持iOS8.2以上版本.
     * @var string|null
     */
    protected $subtitle_loc_key = null;

    /**
     * 当前本地化子标题内容中需要置换的变量参数 ,仅支持iOS8.2以上版本.
     * @var array|null
     */
    protected $subtitle_loc_args = null;

    public function __construct(?string $title = null, ?string $body = null)
    {
        $this->title = $title;
        $this->body = $body;
    }

    public function setTitle(?string $title = null)
    {
        $this->title = $title;
        return $this;
    }

    public function setBody(?string $body = null)
    {
        $this->body = $body;
        return $this;
    }

    public function setActionLocKey(?string $action_loc_key = null)
    {
        $this->action_loc_key = $action_loc_key;
        return $this;
    }

    public function setLocKey(?string $loc_key = null)
    {
        $this->loc_key = $loc_key;
        return $this;
    }

    public function setLocArgs(?array $loc_args = null)
    {
        $this->loc_args = $loc_args;
        return $this;
    }

    public function setLaunchImage(?string $launch_image = null)
    {
        $this->launch_image = $launch_image;
        return $this;
    }

    public function setTitleLocKey(?string $title_loc_key = null)
    {
        $this->title_loc_key = $title_loc_key;
        return $this;
    }

    public function setTitleLocArgs(?array $title_loc_args = null)
    {
        $this->title_loc_args = $title_loc_args;
        return $this;
    }

    public function setSubtitle(?string $subtitle = null)
    {
        $this->subtitle = $subtitle;
        return $this;
    }

    public function setSubtitleLocKey(?string $subtitle_loc_key = null)
    {
        $this->subtitle_loc_key = $subtitle_loc_key;
        return $this;
    }

    public function setSubtitleLocArgs(?array $subtitle_loc_args = null)
    {
        $this->subtitle_loc_args = $subtitle_loc_args;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function toArray(): array
    {
        return array_filter([
            'title' => $this->title,
            'body' => $this->body,
            'action-loc-key' => $this->action_loc_key,
            'loc-key' => $this->loc_key,
            'loc-args' => $this->loc_args,
            'launch-image' => $this->launch_image,
            'title-loc-key' => $this->title_loc_key,
            'title-loc-args' => $this->title_loc_args,
            'subtitle' => $this->subtitle,
            'subtitle-loc-key' => $this->subtitle_loc_key,
            'subtitle-loc-args' => $this->subtitle_loc_args,
        ], function ($v) {
            return !is_null($v);
        });
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
