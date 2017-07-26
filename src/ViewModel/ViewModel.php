<?php

namespace Polass\ViewModel;

use InvalidArgumentException;
use Illuminate\Support\Arr;
use Polass\Fluent\Model;
use Polass\ViewModel\Map;
use Polass\ViewModel\Mutator;
use Polass\ViewModel\Exceptions\KeyIsNotDefinedOnMapException;

class ViewModel extends Model
{
    /**
     * ViewModel の属性と`$attributes` の属性との対応関係
     *
     * @var array
     */
    protected $map = [
        // 'this.key' => 'attributes.key',
    ];

    /**
     * 指定した ViewModel の属性の名前に対応した `$attributes` の属性の名前を取得
     *
     * @param string $key
     * @return (string|array)
     */
    public function map()
    {
        return new Map($this->map);
    }

    /**
     * フィールドが属性を持っているか
     *
     * @param string $key
     * @return bool
     */
    protected function hasAttributeInArray($key)
    {
        return $this->map()->has($key) && Arr::has($this->attributes, $this->map()->get($key));
    }

    /**
     * フィールドから属性を取得
     *
     * @param string $key
     * @return mixed
     */
    protected function getAttributeFromArray($key)
    {
        if ($this->has($key)) {
            return Arr::get($this->attributes, $this->map()->get($key));
        }
        else {
            return null;
        }
    }

    /**
     * フィールドに属性を設定
     *
     * @param string $key
     * @param mixed $value
     * @return void
     *
     * @throws \Polass\ViewModel\Exceptions\KeyIsNotDefinedOnMapException
     */
    protected function setAttributeInArray($key, $value)
    {
        Arr::set($this->attributes, $this->map()->getOrFail($key), $value);
    }

    /**
     * 属性の値を全て取得
     *
     * @return array
     */
    public function getAttributes()
    {
        $attributes = [];

        foreach ($this->map()->keys() as $key) {
            Arr::set($attributes, $key, $this->get($key));
        }

        return $attributes;
    }

    /**
     * 属性をスカラ型に変換
     *
     * @param mixed $attribute
     * @return mixed
     */
    protected function mutateAttribute($attribute)
    {
        return (new Mutator($attribute))->mutate();
    }

    /**
     * Serialize した属性を配列で取得
     *
     * @return array
     */
    public function getMutatedAttributes()
    {
        return (new Mutator($this->getAttributes()))->mutate();
    }

    /**
     * 配列に変換
     *
     * @return array
     */
    public function toArray()
    {
        return $this->wrap($this->getMutatedAttributes());
    }

    /**
     * 配列に変換する際にデータを加工
     *
     * @param array $data
     * @return array
     */
    public function wrap($data)
    {
        return $data;
    }
}
