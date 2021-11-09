<?php

namespace luoyy\GtPush\Support\Push;

use luoyy\GtPush\Contracts\Audience;

class AudienceAll extends Audience
{
    public function data()
    {
        return 'all';
    }
}
