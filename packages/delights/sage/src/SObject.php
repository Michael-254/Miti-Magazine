<?php

namespace Delights\Sage;

use Carbon\Carbon;
use Delights\Sage\Validators\Validator;
use Delights\SageApi\Api;

class SObject
{
    const RESOURCE_NAME = '';
    protected $api;
    protected $attributes;
    protected $fields;
    protected $queryParams  = '';

    public $id;

    /**
     * SageAccountingSObject constructor.
     * @param Api $api
     * @param null $json
     */
    public function __construct(Api $api, $json = null)
    {
        $this->api        = $api;
        $this->id         = $json['id'] ?? $this->id;
        $this->attributes = collect($json);
        $this->fields     = collect($this->fields);
    }

    /**
     * @param Api $api
     * @return static
     */
    public static function make(Api $api)
    {
        return new static($api);
    }

    public function validate($attributes = false, $withRequired = true)
    {
        return (new Validator($this->fields, $attributes ? : $this->attributes))->validate($withRequired);
    }

    public function all()
    {
        $this->queryParams = '';
        return $this->get();
    }

    public function get()
    {
        $data = $this->api->get(static::RESOURCE_NAME, $this->queryParams);
        $items = collect($data["\$items"] ?? []);
        if ($data["\$next"] ?? false) {
            $items = $this->getPaginatedItems($items, $data["\$next"]);
        }
        return $items->map(function ($data) {
            return new static($this->api, $data);
        });
    }

    public function where($field, $condition)
    {
        $this->queryParams .= "{$field}={$condition}&";
        return $this;
    }

    public function whereDate($field, $date)
    {
        $this->queryParams .= "{$field}=" . $this->toIso8601String($date)  . "&";
        return $this;
    }

    public function count()
    {
        return $this->api->get(static::RESOURCE_NAME)["\$total"];
    }

    public function find($id)
    {
        if (! $id) {
            return new static($this->api);
        }
        return new static($this->api,
            $this->api->find(static::RESOURCE_NAME, $id)
        );
    }

    /**
     * @return SObject
     */
    public function create()
    {
        $this->id = $this->api->post(static::RESOURCE_NAME, [str_singular(static::RESOURCE_NAME) => $this->validate()->toArray()]);
        return $this;
    }

    /**
     * @param $attributes
     * @return $this
     */
    public function update($attributes)
    {
        $this->attributes = $this->attributes->merge($attributes);
        $this->api->patch(static::RESOURCE_NAME, $this->id, [str_singular(static::RESOURCE_NAME) => $this->validate(collect($attributes), false)]);
        return $this;
    }

    public function destroy()
    {
        $this->api->delete(static::RESOURCE_NAME, $this->id);
    }

    public function __get($name)
    {
        if (array_has($this->attributes, $name)) {
            return $this->attributes[$name];
        }
        return null;
    }

    private function getPaginatedItems($items, $nextPage)
    {
        $data = $this->api->get($nextPage);
        $items = $items->concat($data["\$items"] ?? []);
        if ($data && $data["\$next"]) {
            return $this->getPaginatedItems($items, $data["\$next"]);
        }
        return $items;
    }

    private function toIso8601String(Carbon $date)
    {
        return str_replace("+", "%2B", $date->toAtomString());
    }
}
