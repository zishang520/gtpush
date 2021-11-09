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
 * TIM DEMO
 */
use luoyy\GtPush\Facades\Push;

var_dump(Push::auth());
var_dump(Push::errCode());
var_dump(Push::errMsg());
```
### 更新日志
* `2021.11.09`：没啥说的，自己看代码[`PushManager.php`](https://github.com/zishang520/gtpush/blob/main/src/PushManager.php)吧，懒得写文档了
