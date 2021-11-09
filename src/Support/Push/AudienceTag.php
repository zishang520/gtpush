<?php

namespace luoyy\GtPush\Support\Push;

use luoyy\GtPush\Contracts\Audience;

class AudienceTag extends Audience
{
    /**
     * 为用户自定义标签，根据fast_custom_tag选择推送用户时使用，绑定标签请参考接口.
     * @var string
     */
    protected $fast_custom_tag;

    /**
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $fast_custom_tag 为用户自定义标签，根据fast_custom_tag选择推送用户时使用，绑定标签请参考接口
     */
    public function __construct(string $fast_custom_tag)
    {
        $this->fast_custom_tag = $fast_custom_tag;
    }

    public function setTag(string $fast_custom_tag)
    {
        $this->fast_custom_tag = $fast_custom_tag;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function data(): array
    {
        return ['fast_custom_tag' => $this->fast_custom_tag];
    }
}
