<?php

namespace luoyy\GtPush\Support\Push;

use luoyy\GtPush\Contracts\MessageData;

class MessageRevoke extends MessageData
{
    /**
     * 需要撤回的taskId.
     * @var string
     */
    protected $old_task_id;

    /**
     * 在没有找到对应的taskId，是否把对应appId下所有的通知都撤回.
     * @var bool|null
     */
    protected $force = null;

    /**
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $old_task_id 需要撤回的taskId
     * @param bool|null $force 在没有找到对应的taskId，是否把对应appId下所有的通知都撤回
     */
    public function __construct(string $old_task_id, ?bool $force = null)
    {
        $this->old_task_id = $old_task_id;
        $this->force = $force;
    }

    public function setOldTaskId(string $old_task_id)
    {
        $this->old_task_id = $old_task_id;
        return $this;
    }

    public function setForce(?bool $force = null)
    {
        $this->force = $force;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function data(): array
    {
        return [
            'revoke' => array_filter([
                'old_task_id' => $this->old_task_id,
                'force' => $this->force,
            ], function ($v) {
                return !is_null($v);
            }),
        ];
    }
}
