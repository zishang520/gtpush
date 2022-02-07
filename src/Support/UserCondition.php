<?php

namespace luoyy\GtPush\Support;

use JsonSerializable;
use luoyy\GtPush\Contracts\Support\Arrayable;
use luoyy\GtPush\Contracts\Support\Jsonable;
use luoyy\GtPush\Contracts\Support\Renderable;

class UserCondition implements JsonSerializable, Arrayable, Renderable, Jsonable
{
    /**
     * 查询条件(phone_type 手机类型,region 省市,custom_tag 用户标签，设置标签请见接口).
     * @var string
     */
    protected $type;

    /**
     * 查询条件值列表，其中 手机型号使用如下参数android和ios； 省市使用编号，点击下载文件region_code.data.
     * @var string[]
     */
    protected $values = [];

    /**
     * or(或),and(与),not(非)，values间的交并补操作.
     * @var string
     */
    protected $logic;

    /**
     * 查询用户总量条件参数.
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $type 查询条件(phone_type 手机类型,region 省市,custom_tag 用户标签，设置标签请见接口)
     * @param string[] $values 查询条件值列表，其中 手机型号使用如下参数android和ios； 省市使用编号，点击下载文件region_code.data；
     * @param string $logic or(或),and(与),not(非)，values间的交并补操作
     */
    public function __construct(string $type, array $values, string $logic)
    {
        $this->type = $type;
        $this->values = $values;
        $this->logic = $logic;
    }

    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function setValues(string ...$values)
    {
        $this->values = $values;
        return $this;
    }

    public function addValues(string ...$values)
    {
        $this->values = array_merge($this->values, $values);
        return $this;
    }

    public function setLogic(string $logic)
    {
        $this->logic = $logic;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function toArray(): array
    {
        return [
            'key' => $this->type,
            'values' => $this->values,
            'opt_type' => $this->logic,
        ];
    }

    /**
     * Convert the object into something JSON serializable.
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
