# 个推SDK RestAPI V2 版本

### 安装包
```bash
composer require luoyy/gtpush
```
###### 在 app.php 中注册服务器提供者(Laravel5.5+支持自动发现)
```php
luoyy\GtPush\Providers\PushServiceProvider
```
###### ENV
```env
#GtPush配置
# APPID
GT_PUSH_APPID=
# APPKEY
GT_PUSH_APPKEY=
# MASTER_SECRET
GT_PUSH_MASTER_SECRET=v2
# 缓存token的key
GT_PUSH_TOKEN_CACHE_NAME="GT-PUSH-TOKEN"
# 给非laravel用的
GT_PUSH_CACHE_CLASS="\Illuminate\Support\Facades\Cache"
```

### Quick Sample Usage
```php
/**
 * GtPush DEMO
 */
use luoyy\GtPush\Facades\Push;

var_dump(Push::auth());
var_dump(Push::errCode());
var_dump(Push::errMsg());
```

```php
/**
 * GtPush example
 */
use Carbon\Carbon;
use luoyy\GtPush\Facades\Push as GtPush;
use luoyy\GtPush\Support\Intent;
use luoyy\GtPush\Support\Push\Android\Channel as AndroidChannel;
use luoyy\GtPush\Support\Push\Android\ChannelUps as AndroidChannelUps;
use luoyy\GtPush\Support\Push\Android\MessageNotification as AndroidMessageNotification;
use luoyy\GtPush\Support\Push\Android\MessageTransmission as AndroidMessageTransmission;
use luoyy\GtPush\Support\Push\AudienceAll;
use luoyy\GtPush\Support\Push\AudienceCid;
use luoyy\GtPush\Support\Push\Channel;
use luoyy\GtPush\Support\Push\Ios\Channel as IosChannel;
use luoyy\GtPush\Support\Push\Ios\ChannelAps as IosChannelAps;
use luoyy\GtPush\Support\Push\Ios\ChannelApsAlert;
use luoyy\GtPush\Support\Push\Message;
use luoyy\GtPush\Support\Push\MessageNotification;
use luoyy\GtPush\Support\Push\Settings;
use luoyy\GtPush\Support\PushObject;

$push_object = new PushObject(
    Carbon::now()->unix(),
    new AudienceCid('cid'), // new AudienceAll(),
    new Message(
        null, // Carbon::now()->getTimestampMs() . '-' . Carbon::now()->addMinutes(15)->getTimestampMs(),
        (new MessageNotification('测试在线标题', '测试在线内容', MessageNotification::PAYLOAD, '{"xxx":1}'))->setBadgeAddNum(1)
    )
);
$push_object->setSettings(
    new Settings(
        null, // 1 * 24 * 3600 * 1000,
        [
            'default' => 1, // 覆盖配置
            'ios' => 4,
            'st' => 1,
            'hw' => 1,
            'xm' => 1,
            'vv' => 1,
            'mz' => 1,
            'op' => 1,
        ]
    ),
);
$push_object->setPushChannel(
    new Channel(
        new AndroidChannel(
            new AndroidChannelUps(
                // new AndroidMessageTransmission('测试透传'),
                new AndroidMessageNotification('测试Android离线推送标题6#', '测试Android离线推送标题内容1', AndroidMessageNotification::INTENT, new Intent('uni.UNI48A0036', 'io.dcloud.PandoraEntry', '测试Inten#t标题#', '测试I#ntent内容#', json_encode(['default' => 1, 'ios#' => 4, 'st' => 1, 'hw' => 1, 'xm' => 1, 'vv' => 1, 'mz' => 1, 'op' => 1]), 'ess', null, 'push')),
                [
                    'ALL' => [
                        'channel' => 'Default',
                    ],
                    'HW' => [
                        '/message/android/notification/badge/add_num' => 1,
                        // '/message/android/notification/badge/set_num' => 0,
                        '/message/android/notification/badge/class' => 'io.dcloud.PandoraEntry',
                        '/message/android/notification/image' => 'https://dss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/topnav/baike@2x-1fe3db7fa6.png',
                        // '/message/android/notification/style' => 1,
                        // '/message/android/notification/big_title' => '测试Android离线推送标题5',
                        // '/message/android/notification/big_body' => '测试Android离线推送标题5测试Android离线推送标题1测试Android离线推送标题1测试Android离线推送标题1测试Android离线推送标题1测试Android离线推送标题1',
                        '/message/android/notification/importance' => 'NORMAL', // LOW
                        // '/message/android/notification/default_sound' => false,
                        // '/message/android/notification/channel_id' => 'RingRing4',
                        // '/message/android/notification/sound' => '/raw/ring002',
                    ],
                    'OP' => [
                        'channel' => 'Default', // 请先去产商设置 新建channel
                        'small_picture_id' => 'xxxxxxxxxxxxxxx',
                        'style' => 3, // 通知长文本 value: 2 长文本和大图二选一。 *或复用通知的content接口，长文本样式（style为2）限制字数128个以内。 通知大图 value: 3 长文本和大图二选一。
                        'big_picture_id' => 'big_body',
                    ],
                    'VV' => [
                        'classification' => 0,
                    ],
                    'XM' => [
                        'channel' => 'push', // 请先去产商设置 新建channel
                        'notification_large_icon_uri' => 'http://url.large.icon/xxx.png',
                        'notification_style_type' => 1,
                        'notification_bigTxt' => 'text less than 128 characters',
                        'notification_bigPic_uri' => 'http://url.big.pic/xxx.png',
                        // 'sound_uri' => 'android.resource://com.pp.infonew/ring001',
                    ],
                ]
            )
        ),
        new IosChannel('notify', new IosChannelAps(
            new ChannelApsAlert('测试IOS离线推送标题1', '测试IOS离线推送标题内容1')
        ), '+1')
    )
);
dump(GtPush::push_single_cid($push_object));
dump(GtPush::errCode());
dump(GtPush::errMsg());
```

### 更新日志
* `2021.11.09`：没啥说的，自己看代码[`PushManager.php`](https://github.com/zishang520/gtpush/blob/main/src/PushManager.php)吧，懒得写文档了
