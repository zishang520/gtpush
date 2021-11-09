<?php

namespace luoyy\GtPush;

use Carbon\Carbon;
use luoyy\GtPush\Support\CreatePushObject;
use luoyy\GtPush\Support\Push\AudienceAlias;
use luoyy\GtPush\Support\Push\AudienceCid;
use luoyy\GtPush\Support\PushObject;
use luoyy\GtPush\Support\UserAlias;
use luoyy\GtPush\Support\UserCondition;

class PushManager extends Push
{
    //**统计API**//

    /**
     * 【推送】获取推送结果.
     * 查询推送数据，可查询消息可下发数、下发数，接收数、展示数、点击数等结果。支持单个taskId查询和多个taskId查询。
     * 此接口调用，可直接查询toList或toApp的taskId的推送结果数据；如需查询toSingle的taskId的推送结果数据，请联系对应的商务同学开通.
     * @see https://docs.getui.com/getui/server/rest_v2/report/#doc-title-1
     * @copyright (c) zishang520 All Rights Reserved
     * @param string[] ...$taskids 任务id，推送时返回，一次最多传200个
     */
    public function push_task_results(string ...$taskids)
    {
        return $this->api('GET', sprintf('report/push/task/%s', implode(',', $taskids)));
    }

    /**
     * 【推送】任务组名查报表.
     * 根据任务组名查询推送结果，返回结果包括消息可下发数、下发数，接收数、展示数、点击数。
     * @see https://docs.getui.com/getui/server/rest_v2/report/#doc-title-2
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $group_name 任务组名
     */
    public function push_task_group(string $group_name)
    {
        return $this->api('GET', sprintf('report/push/task_group/%s', $group_name));
    }

    /**
     * 【推送】获取推送实时结果.
     * 获取推送实时结果，可查询消息下发数，接收数、展示数、点击数和消息折损详情等结果。支持单个taskId查询和多个taskId查询。
     * 注意：该接口需要开通权限，如需开通，请联系对应的商务同学开通.
     * @see https://docs.getui.com/getui/server/rest_v2/report/#doc-title-3
     * @copyright (c) zishang520 All Rights Reserved
     * @param string[] ...$taskid 任务id，推送时返回，一次最多传200个
     */
    public function push_task_detail(string ...$taskids)
    {
        return $this->api('GET', sprintf('report/push/task/%s/detail', implode(',', $taskids)));
    }

    /**
     * 【推送】获取单日推送数据.
     * 调用此接口可以获取某个应用单日的推送数据(推送数据包括：下发数，接收数、展示数、点击数)(目前只支持查询非当天的数据).
     * @see https://docs.getui.com/getui/server/rest_v2/report/#doc-title-4
     * @copyright (c) zishang520 All Rights Reserved
     * @param string|\DateTimeInterface|null $date 日期，默认当前日期
     */
    public function push_date_results($date = null)
    {
        return $this->api('GET', sprintf('report/push/date/%s', Carbon::parse($date)->toDateString()));
    }

    /**
     * 【推送】查询推送量.
     * 查询应用当日可推送量和推送余量
     * 注意： 1. 部分厂商消息不限制推送量，所以此接口不做返回，例如 hw/xmg厂商，op的私信消息，xm的重要级别消息等等 2.vv返回的是请求量push_num，总限额total_num返回的总的到达量，所以会有请求量push_num超过总限额total_num的情况 3.该接口做了频控限制，请不要频繁调用.
     * @see https://docs.getui.com/getui/server/rest_v2/report/#doc-title-5
     * @copyright (c) zishang520 All Rights Reserved
     */
    public function push_count()
    {
        return $this->api('GET', 'report/push/count');
    }

    /**
     * 【用户】获取单日用户数据接口.
     * 调用此接口可以获取某个应用单日的用户数据(用户数据包括：新增用户数，累计注册用户总数，在线峰值，日联网用户数)(目前只支持查询非当天的数据).
     * @see https://docs.getui.com/getui/server/rest_v2/report/#doc-title-6
     * @copyright (c) zishang520 All Rights Reserved
     * @param string|\DateTimeInterface|null $date 日期，默认当前日期
     */
    public function user_date_results($date = null)
    {
        return $this->api('GET', sprintf('report/user/date/%s', Carbon::parse($date)->toDateString()));
    }

    /**
     * 【用户】获取24个小时在线用户数.
     * 查询当前时间一天内的在线用户数(10分钟一个点，1个小时六个点).
     * @see https://docs.getui.com/getui/server/rest_v2/report/#doc-title-7
     * @copyright (c) zishang520 All Rights Reserved
     */
    public function online_user()
    {
        return $this->api('GET', 'report/online_user');
    }

    //**统计API**//

    //**用户API**//

    /**
     * 【别名】绑定别名.
     * 一个cid只能绑定一个别名，若已绑定过别名的cid再次绑定新别名，则前一个别名会自动解绑，并绑定新别名。
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-1
     * @copyright (c) zishang520 All Rights Reserved
     * @param \luoyy\GtPush\Support\UserAlias[] ...$datas 数据列表，数组长度不大于1000
     */
    public function user_alias(UserAlias ...$datas)
    {
        return $this->api('POST', 'user/alias', ['data_list' => array_map(function ($data) {
            return $data->toArray();
        }, $datas)]);
    }

    /**
     * 【别名】根据cid查询别名.
     * 通过传入的cid查询对应的别名信息.
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-2
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $cid 用户唯一标识
     */
    public function user_alias_by_cid(string $cid)
    {
        return $this->api('GET', sprintf('user/alias/cid/%s', $cid));
    }

    /**
     * 【别名】根据cid查询别名.
     * 通过传入的别名查询对应的cid信息.
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-3
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $alias 别名
     */
    public function user_cid_by_alias(string $alias)
    {
        return $this->api('GET', sprintf('user/cid/alias/%s', $alias));
    }

    /**
     * 【别名】批量解绑别名.
     * 批量解除别名与cid的关系.
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-4
     * @copyright (c) zishang520 All Rights Reserved
     */
    public function user_delete_alias()
    {
        return $this->api('DELETE', 'user/alias');
    }

    /**
     * 【别名】解绑所有别名.
     * 解绑所有与该别名绑定的cid.
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-5
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $alias 别名
     */
    public function user_delete_alias_by_alias(string $alias)
    {
        return $this->api('DELETE', sprintf('user/alias/%s', $alias));
    }

    /**
     * 【标签】一个用户绑定一批标签.
     * 一个用户绑定一批标签，此操作为覆盖操作，会删除历史绑定的标签.
     * 此接口对单个cid有频控限制，每天只能修改一次，最多设置100个标签；单个标签长度最大为32字符，标签总长度最大为512个字符，申请修改请点击右侧“技术咨询”了解详情.
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-6
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $cid 用户唯一标识
     * @param string[] ...$custom_tag 标签列表，标签中不能包含空格
     */
    public function user_tag(string $cid, string ...$custom_tag)
    {
        return $this->api('POST', sprintf('user/custom_tag/cid/%s', $cid), [
            'custom_tag' => array_map('strval', $custom_tag),
        ]);
    }

    /**
     * 【标签】一批用户绑定一个标签.
     * 一批用户绑定一个标签，此接口为增量.
     * 此接口有频次控制(每分钟最多100次，每天最多10000次)，申请修改请点击右侧“技术咨询”了解详情.
     * 此接口是异步的，会有延迟.
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-7
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $custom_tag 用户标签，标签中不能包含空格，单个标签最大长度为32字符，如果含有中文字符需要编码(UrlEncode)
     * @param string[] ...$cids 要修改标签属性的cid列表，数组长度不大于1000
     */
    public function user_tag_add_cids(string $custom_tag, string ...$cids)
    {
        return $this->api('PUT', sprintf('user/custom_tag/batch/%s', $custom_tag), [
            'cid' => array_map('strval', $cids),
        ]);
    }

    /**
     * 【标签】一批用户解绑一个标签.
     * 解绑用户的某个标签属性，不影响其它标签.
     * 此接口有频次控制(每分钟最多100次，每天最多10000次)，申请修改请点击右侧“技术咨询”了解详情.
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-8
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $custom_tag 用户标签，标签中不能包含空格，如果含有中文字符需要编码(UrlEncode)
     * @param string[] ...$cids 要删除标签属性的cid列表，数组长度不大于1000
     */
    public function user_tag_delete_cids(string $custom_tag, string ...$cids)
    {
        return $this->api('DELETE', sprintf('user/custom_tag/batch/%s', $custom_tag), [
            'cid' => array_map('strval', $cids),
        ]);
    }

    /**
     * 【标签】查询用户标签.
     * 根据cid查询用户标签列表.
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-9
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $cid 用户唯一标识
     */
    public function user_tag_by_cid(string $cid)
    {
        return $this->api('GET', sprintf('user/custom_tag/cid/%s', $cid));
    }

    /**
     * 【用户】添加黑名单用户.
     * 将单个或多个用户加入黑名单，对于黑名单用户在推送过程中会被过滤掉。
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-10
     * @copyright (c) zishang520 All Rights Reserved
     * @param string[] ...$cid 用户标识，多个以英文逗号隔开，一次最多传1000个
     */
    public function user_black_add_cids(string ...$cids)
    {
        return $this->api('POST', sprintf('user/black/cid/%s', implode(',', $cids)));
    }

    /**
     * 【用户】添加黑名单用户.
     * 将单个cid或多个cid用户移出黑名单，对于黑名单用户在推送过程中会被过滤掉的，不会给黑名单用户推送消息.
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-11
     * @copyright (c) zishang520 All Rights Reserved
     * @param string[] ...$cid 用户标识，多个以英文逗号隔开，一次最多传1000个
     */
    public function user_black_delete_cids(string ...$cids)
    {
        return $this->api('DELETE', sprintf('user/black/cid/%s', implode(',', $cids)));
    }

    /**
     * 【用户】查询用户状态.
     * 查询用户的状态
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-12
     * @copyright (c) zishang520 All Rights Reserved
     * @param string[] ...$cid 用户标识，多个以英文逗号隔开，一次最多传1000个
     */
    public function user_status_cids(string ...$cids)
    {
        return $this->api('GET', sprintf('user/status/%s', implode(',', $cids)));
    }

    /**
     * 【用户】查询设备状态.
     * 查询设备的状态
     * 注意： 1. 该接口返回设备在线时，仅表示存在集成了个推SDK的应用在线 2.该接口返回设备不在线时，仅表示不存在集成了个推SDK的应用在线 3.该接口需要开通权限，如需开通，请联系右侧技术咨询.
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-13
     * @copyright (c) zishang520 All Rights Reserved
     * @param string[] ...$cid 用户标识，多个以英文逗号隔开，一次最多传1000个
     */
    public function user_device_status_cids(string ...$cids)
    {
        return $this->api('GET', sprintf('user/deviceStatus/%s', implode(',', $cids)));
    }

    /**
     * 【用户】查询用户状态.
     * 查询用户的信息.
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-14
     * @copyright (c) zishang520 All Rights Reserved
     * @param string[] ...$cid 用户标识，多个以英文逗号隔开，一次最多传1000个
     */
    public function user_detail_cids(string ...$cids)
    {
        return $this->api('GET', sprintf('user/detail/%s', implode(',', $cids)));
    }

    /**
     * 【用户】设置角标(仅支持IOS).
     * 通过cid通知个推服务器当前iOS设备的角标情况。
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-15
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $badge 用户应用icon上显示的数字 +N: 在原有badge上+N -N: 在原有badge上-N N: 直接设置badge(数字，会覆盖原有的badge值)
     * @param string[] ...$cid 用户标识，多个以英文逗号隔开，一次最多传1000个
     */
    public function user_badge_by_cids(string $badge, string ...$cids)
    {
        return $this->api('POST', sprintf('user/badge/cid/%s', implode(',', $cids)), ['badge' => $badge]);
    }

    /**
     * 【用户】查询用户总量.
     * 通过指定查询条件来查询满足条件的用户数量.
     * @see https://docs.getui.com/getui/server/rest_v2/user/#doc-title-16
     * @copyright (c) zishang520 All Rights Reserved
     * @param \luoyy\GtPush\Support\UserCondition[] ...$conditions 查询条件
     */
    public function user_count(UserCondition ...$conditions)
    {
        return $this->api('POST', 'user/count', [
            'tag' => array_map(function ($condition) {
                return $condition->toArray();
            }, $conditions),
        ]);
    }

    //**用户API**//

    //**推送API**//

    /**
     * 【toSingle】执行cid单推.
     * 向单个用户推送消息，可根据cid指定用户.
     * @see https://docs.getui.com/getui/server/rest_v2/push/#doc-title-1
     * @copyright (c) zishang520 All Rights Reserved
     * @param \luoyy\GtPush\Support\PushObject $push_object 推送消息结构
     */
    public function push_single_cid(PushObject $push_object)
    {
        return $this->api('POST', 'push/single/cid', $push_object->toArray());
    }

    /**
     * 【toSingle】执行别名单推.
     * 通过别名推送消息，绑定别名请参考接口.
     * @see https://docs.getui.com/getui/server/rest_v2/push/#doc-title-2
     * @copyright (c) zishang520 All Rights Reserved
     * @param \luoyy\GtPush\Support\PushObject $push_object 推送消息结构
     */
    public function push_single_alias(PushObject $push_object)
    {
        return $this->api('POST', 'push/single/alias', $push_object->toArray());
    }

    /**
     * 【toSingle】执行cid批量单推.
     * 批量发送单推消息，每个cid用户的推送内容都不同的情况下，使用此接口，可提升推送效率。
     * @see https://docs.getui.com/getui/server/rest_v2/push/#doc-title-3
     * @copyright (c) zishang520 All Rights Reserved
     * @param \luoyy\GtPush\Support\PushObject[] ...$push_objects 推送消息结构
     */
    public function push_single_batch_cid(bool $is_async, PushObject ...$push_objects)
    {
        return $this->api('POST', 'push/single/batch/cid', [
            'is_async' => $is_async,
            'msg_list' => array_map(function ($push_object) {
                return $push_object->toArray();
            }, $push_objects),
        ]);
    }

    /**
     * 【toSingle】执行别名批量单推.
     * 批量发送单推消息，在给每个别名用户的推送内容都不同的情况下，可以使用此接口.
     * @see https://docs.getui.com/getui/server/rest_v2/push/#doc-title-4
     * @copyright (c) zishang520 All Rights Reserved
     * @param \luoyy\GtPush\Support\PushObject[] ...$push_objects 推送消息结构
     */
    public function push_single_batch_alias(bool $is_async, PushObject ...$push_objects)
    {
        return $this->api('POST', 'push/single/batch/alias', [
            'is_async' => $is_async,
            'msg_list' => array_map(function ($push_object) {
                return $push_object->toArray();
            }, $push_objects),
        ]);
    }

    /**
     * 【toList】创建消息.
     * 此接口用来创建消息体，并返回taskid，为批量推的前置步骤
     * 注：此接口频次限制200万次/天(和执行别名批量推共享限制)，申请修改请点击右侧“技术咨询”了解详情。
     * @see https://docs.getui.com/getui/server/rest_v2/push/#doc-title-5
     * @copyright (c) zishang520 All Rights Reserved
     * @param \luoyy\GtPush\Support\CreatePushObject $create_push_object 推送消息结构
     */
    public function push_list_message(CreatePushObject $create_push_object)
    {
        return $this->api('POST', 'push/list/message', $create_push_object->toArray());
    }

    /**
     * 【toList】执行cid批量推.
     * 对列表中所有cid进行消息推送。调用此接口前需调用创建消息接口设置消息内容。
     * @see https://docs.getui.com/getui/server/rest_v2/push/#doc-title-6
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $taskid 使用创建消息接口返回的taskId，可以多次使用
     * @param \luoyy\GtPush\Support\AudienceCid $audience_cid 推送目标用户
     * @param bool $is_async 是否异步推送，true是异步，false同步。异步推送不会返回data详情
     */
    public function push_list_cid(string $taskid, AudienceCid $audience_cid, ?bool $is_async = false)
    {
        return $this->api('POST', 'push/list/cid', [
            'audience' => $audience_cid->toArray(),
            'taskid' => $taskid,
            'is_async' => $is_async,
        ]);
    }

    /**
     * 【toList】执行别名批量推.
     * 对列表中所有别名进行消息推送。调用此接口前需调用创建消息接口设置消息内容。
     * 注：此接口频次限制200万次/天(和执行cid批量推共享限制)，申请修改请点击右侧“技术咨询”了解详情。
     * @see https://docs.getui.com/getui/server/rest_v2/push/#doc-title-7
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $taskid 使用创建消息接口返回的taskId，可以多次使用
     * @param \luoyy\GtPush\Support\AudienceAlias $audience_alias 推送目标用户
     * @param bool $is_async 是否异步推送，true是异步，false同步。异步推送不会返回data详情
     */
    public function push_list_alias(string $taskid, AudienceAlias $audience_alias, ?bool $is_async = false)
    {
        return $this->api('POST', 'push/list/alias', [
            'audience' => $audience_alias->toArray(),
            'taskid' => $taskid,
            'is_async' => $is_async,
        ]);
    }

    /**
     * 【toApp】执行群推.
     * 对指定应用的所有用户群发推送消息。支持定时、定速功能，查询任务推送情况请见接口查询定时任务。
     * 注：此接口频次限制100次/天，每分钟不能超过5次(推送限制和接口根据条件筛选用户推送共享限制)，定时推送功能需要申请开通才可以使用，申请修改请点击右侧“技术咨询”了解详情。
     * @see https://docs.getui.com/getui/server/rest_v2/push/#doc-title-8
     * @copyright (c) zishang520 All Rights Reserved
     * @param \luoyy\GtPush\Support\PushObject $push_object 推送消息结构
     */
    public function push_all(PushObject $push_object)
    {
        return $this->api('POST', 'push/all', $push_object->toArray());
    }

    /**
     * 【toApp】根据条件筛选用户推送.
     * 对指定应用的符合筛选条件的用户群发推送消息。支持定时、定速功能。
     * 注：此接口频次限制100次/天，每分钟不能超过5次(推送限制和接口执行群推共享限制)，定时推送功能需要申请开通才可以使用，申请修改请点击右侧“技术咨询”了解详情。
     * @see https://docs.getui.com/getui/server/rest_v2/push/#doc-title-9
     * @copyright (c) zishang520 All Rights Reserved
     * @param \luoyy\GtPush\Support\PushObject $push_object 推送消息结构
     */
    public function push_tags(PushObject $push_object)
    {
        return $this->api('POST', 'push/tag', $push_object->toArray());
    }

    /**
     * 【toApp】使用标签快速推送.
     * 根据标签过滤用户并推送。支持定时、定速功能。
     * 注：该功能需要申请相关套餐，请点击右侧“技术咨询”了解详情 。
     * @see https://docs.getui.com/getui/server/rest_v2/push/#doc-title-10
     * @copyright (c) zishang520 All Rights Reserved
     * @param \luoyy\GtPush\Support\PushObject $push_object 推送消息结构
     */
    public function push_tag(PushObject $push_object)
    {
        return $this->api('POST', 'push/fast_custom_tag', $push_object->toArray());
    }

    /**
     * 【任务】停止任务.
     * 对正处于推送状态，或者未接收的消息停止下发（只支持批量推和群推任务）.
     * @see https://docs.getui.com/getui/server/rest_v2/push/#doc-title-11
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $taskid 任务id (格式RASL-MMdd_XXXXXX或RASA-MMdd_XXXXXX)
     */
    public function task_delete(string $taskid)
    {
        return $this->api('DELETE', sprintf('task/%s', $taskid));
    }

    /**
     * 【任务】查询定时任务.
     * 该接口支持在推送完定时任务之后，查看定时任务状态，定时任务是否发送成功。
     * 创建定时任务请见接口执行群推.
     * @see https://docs.getui.com/getui/server/rest_v2/push/#doc-title-12
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $taskid 任务id (格式RASL-MMdd_XXXXXX或RASA-MMdd_XXXXXX)
     */
    public function task_schedule(string $taskid)
    {
        return $this->api('GET', sprintf('task/schedule/%s', $taskid));
    }

    /**
     * 【任务】删除定时任务.
     * 用来删除还未下发的任务，删除后定时任务不再触发(距离下发还有一分钟的任务，将无法删除，后续可以调用停止任务接口。).
     * @see https://docs.getui.com/getui/server/rest_v2/push/#doc-title-13
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $taskid 任务id (格式RASL-MMdd_XXXXXX或RASA-MMdd_XXXXXX)
     */
    public function task_schedule_delete(string $taskid)
    {
        return $this->api('DELETE', sprintf('task/schedule/%s', $taskid));
    }

    /**
     * 【推送】查询消息明细.
     * 调用此接口可以查询某任务下某cid的具体实时推送路径情况
     * 使用该接口需要申请权限，若有需要，请点击右侧“技术咨询”了解详情.
     * @see https://docs.getui.com/getui/server/rest_v2/push/#doc-title-14
     * @copyright (c) zishang520 All Rights Reserved
     * @param string $cid cid
     * @param string $taskid 任务id (格式RASL-MMdd_XXXXXX或RASA-MMdd_XXXXXX)
     */
    public function task_detail(string $cid, string $taskid)
    {
        return $this->api('GET', sprintf('task/detail/%s/%s', $cid, $taskid));
    }

    //**推送API**//
}
