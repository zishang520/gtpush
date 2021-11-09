<?php

namespace luoyy\GtPush\Support\Push\Android;

class MessageRevoke extends MessageData
{
    /**
     * 需要撤回的taskId.
     * @var string
     */
    protected $old_task_id;

    /**
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $old_task_id 需要撤回的taskId
     */
    public function __construct(string $old_task_id)
    {
        $this->old_task_id = $old_task_id;
    }

    public function setOldTaskId(string $old_task_id)
    {
        $this->old_task_id = $old_task_id;
        return $this;
    }

    /**
     * Convert the fluent instance to an array.
     */
    public function data(): array
    {
        return [
            'revoke' => [
                'old_task_id' => $this->old_task_id,
            ],
        ];
    }
}
