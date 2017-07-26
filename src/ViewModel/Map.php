<?php

namespace Polass\ViewModel;

use Polass\Fluent\model;
use Polass\ViewModel\Exceptions\KeyIsNotDefinedOnMapException;

class Map extends Model
{
    /**
     * キーを取得
     *
     * @return array
     */
    public function keys()
    {
        return array_keys($this->attributes);
    }

    /**
     * 属性を取得または例外を投げる
     *
     * @param string $key
     * @return mixed
     *
     * @throws \Polass\ViewModel\Exceptions\KeyIsNotDefinedOnMapException
     */
    public function getOrFail($key)
    {
        if (! $this->has($key)) {
            throw (new KeyIsNotDefinedOnMapException)->setKey($key, $this);
        }

        return parent::get($key);
    }
}
