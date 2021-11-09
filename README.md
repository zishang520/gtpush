# 腾讯 即时通信 IM(TIM)

### 安装包
```bash
composer require luoyy/tim
```
###### 在 app.php 中注册服务器提供者(Laravel5.5+支持自动发现)
```php
luoyy\Tim\Providers\TimServiceProvider
```
###### ENV
```env
#Tim配置
# App 在即时通信 IM 控制台获取的应用标识
TIM_SDK_APPID=
# 用户名，调用 REST API 时必须为 App 管理员帐号
TIM_IDENTIFIER=
# 生成 UserSig 的组件库版本 默认 v2 对称加密，如果要使用非对称加密请使用v1
TIM_TLS=v2
# v2 对称加密使用的谜语
TIM_SECRET_KEY=
# v1 非对称加密使用的公钥，只需要中间部分，且去除换行
TIM_PUBLIC_KEY=
# v1 非对称加密使用的私钥，只需要中间部分，且去除换行
TIM_PRIVATE_KEY=
```

### Quick Sample Usage
```php
/**
 * TIM DEMO
 */
use luoyy\Tim\Facades\Tim;

var_dump(Tim::portrait_get(['test'], [Tag::TAG_PROFILE_IM_NICK]));
var_dump(Tim::errCode());
var_dump(Tim::errMsg());
```
### 更新日志
* `2020.12.23`：新增一些API接口，具体请查看commit
* `2020.07.31`：更新版本到3.0，完善一些注释内容，添加全员推送 all_member_push 相关接口，2.0升级请注意querystate接口参数已修改，具体请查看commit
* `2021.11.05`：更新版本到3.2，完善一些注释内容，添加查询帐号在线状态 query_online_status 接口(旧的接口弃用，请注意)，添加 最近联系人 相关API，具体请查看commit
