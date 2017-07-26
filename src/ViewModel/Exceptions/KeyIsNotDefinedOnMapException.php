<?php

namespace Polass\ViewModel\Exceptions;

use LogicException;

class KeyIsNotDefinedOnMapException extends LogicException
{
    /**
     * Model の属性と ViewModel の属性の対応表
     *
     * @var array
     */
    protected $map;

    /**
     * 探した属性の名前
     *
     * @var string
     */
    protected $key;

    /**
     * 探した ViewModel の属性の名前とそのときの対応表を設定
     *
     * @param  string  $key
     * @param  array  $map
     * @return $this
     */
    public function setKey($key, $map = null)
    {
        $this->key = $key;
        $this->map = $map;

        $this->message = "Key `{$this->key}` is not defined on map.";

        return $this;
    }

    /**
     * 探した属性の名前を取得
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * 属性を探した対応表を取得
     *
     * @return array
     */
    public function getMap()
    {
        return $this->map;
    }
}
