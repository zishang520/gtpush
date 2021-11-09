<?php

namespace luoyy\GtPush\Support\Push;

use luoyy\GtPush\Contracts\Audience;

class AudienceAlias extends Audience
{
    /**
     * 别名数组，只能填一个别名；绑定别名请参考.
     * @var string[]
     */
    protected $alias = [];

    /**
     * @copyright (c) zishang520 All Rights Reserved
     */
    public function __construct(string ...$alias)
    {
        $this->alias = $alias;
    }

    public function setAlias(string ...$alias)
    {
        $this->alias = $alias;
        return $this;
    }

    public function addAlias(string ...$alias)
    {
        $this->alias = array_merge($this->alias, $alias);
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function data(): array
    {
        return ['alias' => $this->alias];
    }
}
