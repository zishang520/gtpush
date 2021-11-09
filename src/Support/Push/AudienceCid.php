<?php

namespace luoyy\GtPush\Support\Push;

use luoyy\GtPush\Contracts\Audience;

class AudienceCid extends Audience
{
    /**
     * 根据cids选择推送目标用户时使用.
     * @var string[]
     */
    protected $cids = [];

    /**
     * @copyright (c) zishang520 All Rights Reserved
     */
    public function __construct(string ...$cids)
    {
        $this->cids = $cids;
    }

    public function setCid(string ...$cids)
    {
        $this->cids = $cids;
        return $this;
    }

    public function addCid(string ...$cids)
    {
        $this->cids = array_merge($this->cids, $cids);
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function data(): array
    {
        return ['cid' => $this->cids];
    }
}
