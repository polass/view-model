<?php

namespace Polass\ViewModel;

use Illuminate\Support\Collection;
use Polass\ViewModel\ViewModel;

class ListViewModel extends ViewModel
{
    /**
     * `$attributes` の属性と ViewModel の属性との対応関係
     *
     * @var array
     */
    protected $map = [
        'items' => 'items',
    ];

    /**
     * コンストラクタ
     *
     * @param \Illuminate\Support\Collection $items
     * @param string $class
     */
    public function __construct(Collection $items, $class)
    {
        $this->attributes['items'] = $items->map(function($item) use ($class) {
            return new $class($item);
        });
    }

    /**
     * 配列に変換
     *
     * @return array
     */
    public function toArray()
    {
        return $this->toCollection()->get('items');
    }
}
