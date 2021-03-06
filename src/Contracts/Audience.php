<?php

namespace luoyy\GtPush\Contracts;

use JsonSerializable;
use luoyy\GtPush\Contracts\Support\Arrayable;
use luoyy\GtPush\Contracts\Support\Jsonable;
use luoyy\GtPush\Contracts\Support\Renderable;

abstract class Audience implements JsonSerializable, Arrayable, Renderable, Jsonable
{
    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    abstract public function data();

    /**
     * Convert the fluent instance to an array.
     *
     * @return mixed
     */
    public function toArray(): array
    {
        return $this->data();
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return mixed
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function render()
    {
        return $this->toJson();
    }

    /**
     * Convert the fluent instance to JSON.
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
