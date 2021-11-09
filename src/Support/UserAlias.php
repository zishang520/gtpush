<?php

namespace luoyy\GtPush\Support;

use JsonSerializable;
use luoyy\GtPush\Contracts\Support\Arrayable;
use luoyy\GtPush\Contracts\Support\Jsonable;
use luoyy\GtPush\Contracts\Support\Renderable;

class UserAlias implements JsonSerializable, Arrayable, Renderable, Jsonable
{
    /**
     * 用户标识.
     * @var string
     */
    private $cid;

    /**
     * 别名，有效的别名组成： 字母（区分大小写）、数字、下划线、汉字; 长度<40; 一个别名最多允许绑定10个cid.
     * @var string
     */
    private $alias;

    /**
     * 查询用户总量条件参数.
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $cid 用户标识
     * @param string $alias 别名，有效的别名组成： 字母（区分大小写）、数字、下划线、汉字; 长度<40; 一个别名最多允许绑定10个cid
     */
    public function __construct(string $cid, string $alias)
    {
        $this->cid = $cid;
        $this->alias = $alias;
    }

    public function setCid(string $cid)
    {
        $this->cid = $cid;
        return $this;
    }

    public function setAlias(string $alias)
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'cid' => $this->cid,
            'alias' => $this->alias,
        ];
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
