<?php

return [
    'appid' => env('GT_PUSH_APPID'),
    'appkey' => env('GT_PUSH_APPKEY'),
    'master_secret' => env('GT_PUSH_MASTER_SECRET'),
    // 缓存key
    'token_cache_name' => env('GT_PUSH_TOKEN_CACHE_NAME', 'GT-PUSH-TOKEN'),
    // 默认的缓存对象
    'cache_class' => env('GT_PUSH_CACHE_CLASS', \Illuminate\Support\Facades\Cache::class),
];
