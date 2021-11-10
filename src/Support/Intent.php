<?php

namespace luoyy\GtPush\Support;

use luoyy\GtPush\Contracts\Support\Renderable;

class Intent implements Renderable
{
    /**
     * 协议.
     * @var string|null
     */
    protected $scheme = null;

    /**
     * 主机地址.
     * @var string|null
     */
    protected $host = null;

    /**
     * 路径地址
     * @var string|null
     */
    protected $path = null;

    /**
     * 启动标识.
     * @var string
     */
    protected $launchFlags = '0x4000000';

    /**
     * 不晓得干啥的.
     * @var string
     */
    protected $up_ol_su = 'true';

    /**
     * 应用包名.
     * @var string
     */
    protected $package_name;

    /**
     * activity.
     * @var string
     */
    protected $activity;

    /**
     * 推送的标题.
     * @var string
     */
    protected $title;

    /**
     * 推送的内容.
     * @var string
     */
    protected $body;

    /**
     * 推送的附加内容.
     * @var string
     */
    protected $payload;

    public function __construct(string $package_name, string $activity, string $title, string $body, string $payload, ?string $scheme = null, ?string $host = null, ?string $path = null, string $launchFlags = '0x4000000', bool $up_ol_su = true)
    {
        $this->package_name = $package_name;
        $this->activity = $activity;
        $this->title = $title;
        $this->body = $body;
        $this->payload = $payload;
        $this->scheme = $scheme;
        $this->host = $host;
        $this->path = $path;
        $this->launchFlags = $launchFlags;
        $this->up_ol_su = $up_ol_su ? 'true' : 'false';
    }

    public function __toString()
    {
        return sprintf('intent://%s/%s?#Intent;%s;end', $this->host ?? $this->package_name, $this->path ?? '', $this->buildIntent());
    }

    public function setScheme(?string $scheme = null)
    {
        $this->scheme = $scheme;
        return $this;
    }

    public function setHost(?string $host = null)
    {
        $this->host = $host;
        return $this;
    }

    public function setPath(?string $path = null)
    {
        $this->path = $path;
        return $this;
    }

    public function setLaunchFlags(string $launchFlags = '0x4000000')
    {
        $this->launchFlags = $launchFlags;
        return $this;
    }

    public function setUpOlSu(bool $up_ol_su = true)
    {
        $this->up_ol_su = $up_ol_su ? 'true' : 'false';
        return $this;
    }

    public function setPackageName(string $package_name)
    {
        $this->package_name = $package_name;
        return $this;
    }

    public function setActivity(string $activity)
    {
        $this->activity = $activity;
        return $this;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    public function setBody(string $body)
    {
        $this->body = $body;
        return $this;
    }

    public function setPayload(string $payload)
    {
        $this->payload = $payload;
        return $this;
    }

    public function render()
    {
        return $this->__toString();
    }

    protected function buildIntent()
    {
        $intent = [];
        if (!is_null($this->scheme)) {
            $intent['scheme'] = $this->scheme;
        }
        $intent['launchFlags'] = $this->launchFlags;
        $intent['component'] = sprintf('%s/%s', $this->package_name, $this->activity);
        $intent['S.UP-OL-SU'] = $this->up_ol_su;
        $intent['S.title'] = $this->title;
        $intent['S.content'] = $this->body;
        $intent['S.payload'] = $this->payload;

        return http_build_query($intent, '', ';', PHP_QUERY_RFC3986);
    }
}
