<?php

namespace luoyy\GtPush\Support\Push;

use luoyy\GtPush\Contracts\Audience;
use luoyy\GtPush\Support\UserCondition;

class AudienceTags extends Audience
{
    /**
     * tag 指群推接口的用户筛选条件(包含多种类型条件：phone_type 手机类型; region 省市; custom_tag 用户标签)，详细格式见接口中参数说明.
     * @var UserCondition[]
     */
    protected $tags = [];

    /**
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $fast_custom_tag 为用户自定义标签，根据fast_custom_tag选择推送用户时使用，绑定标签请参考接口
     */
    public function __construct(UserCondition ...$tags)
    {
        $this->tags = $tags;
    }

    public function setTags(UserCondition ...$tags)
    {
        $this->tags = $tags;
        return $this;
    }

    public function addTags(UserCondition ...$tags)
    {
        $this->tags = array_merge($this->tags, $tags);
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function data(): array
    {
        return [
            'tag' => array_map(function ($tag) {
                return $tag->toArray();
            }, $this->tags),
        ];
    }
}
