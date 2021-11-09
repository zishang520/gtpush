<?php

namespace luoyy\GtPush\Facades;

use Illuminate\Support\Facades\Facade;
use luoyy\GtPush\PushManager;

class Push extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PushManager::class;
    }
}
