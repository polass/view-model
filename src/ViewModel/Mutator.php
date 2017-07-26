<?php

namespace Polass\ViewModel;

use DateTime;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Arrayable;
use Polass\Enum\Enum;

class Mutator
{
    /**
     * 変換対象の値
     *
     * @var mixed
     */
    protected $value;

    /**
     * 不明な型
     *
     * @var string
     */
    const UNKNOWN = 'Unknown';

    /**
     * 変換したい値を含む Mutator インスタンスを作成
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * 値の種類が一致するかを返すメソッドの名前を配列で取得
     *
     * @return array
     */
    protected function getTypeCheckers()
    {
        $checkers = [];

        foreach (get_class_methods($this) as $method) {
            if (preg_match('/\Ais(.+)Value\z/', $method, $matches)) {
                $checkers[$matches[1]] = $method;
            }
        }

        return $checkers;
    }

    /**
     * 変換対象の値の種類を取得
     *
     * @return string
     */
    public function getType()
    {
        foreach ($this->getTypeCheckers() as $type => $checker) {
            if (call_user_func([ $this, $checker ], $this->value)) {
                return $type;
            }
        }

        return static::UNKNOWN;
    }

    /**
     * 配列かスカラ型に変換するメソッドの名前を取得
     *
     * @param string $type
     * @return string
     */
    protected function getMutator()
    {
        return 'mutate'.Str::studly($this->getType($this->value));
    }

    /**
     * 変換対象の値を配列かスカラ型に変換
     *
     * @return mixed
     */
    public function mutate()
    {
        return call_user_func([ $this, $this->getMutator() ], $this->value);
    }

    /**
     * DateTime 型かどうか
     *
     * @param mixed $value
     * @return bool
     */
    protected function isDateTimeValue($value)
    {
        return $value instanceOf DateTime;
    }

    /**
     * DateTime 型の値を W3C 形式の文字列に変換
     *
     * @param \DateTime $value
     * @return string
     */
    protected function mutateDateTime(DateTime $value)
    {
        return $value->format(DateTime::W3C);
    }

    /**
     * Enum 型かどうか
     *
     * @param \Polass\Enum\Enum $value
     * @return bool
     */
    protected function isEnumValue($value)
    {
        return $value instanceOf Enum;
    }

    /**
     * Enum インスタンスの値を取得
     *
     * @param \Polass\Enum\Enum $value
     * @return mixed
     */
    protected function mutateEnum(Enum $value)
    {
        return $value->value;
    }

    /**
     * 配列かどうか
     *
     * @param mixed $value
     * @return bool
     */
    protected function isArrayValue($value)
    {
        return is_array($value);
    }

    /**
     * 配列の中身を変換
     *
     * @param array $value
     * @return array
     */
    protected function mutateArray(array $values)
    {
        $mutated = [];

        foreach ($values as $key => $value) {
            $mutated[$key] = (new static($value))->mutate();
        }

        return $mutated;
    }

    /**
     * Arrayable 型かどうか
     *
     * @param mixed $value
     * @return bool
     */
    protected function isArrayableValue($value)
    {
        return $value instanceOf Arrayable;
    }

    /**
     * Arrayable 型を配列に変換
     *
     * @param Collection $value
     * @return array
     */
    protected function mutateArrayable(Arrayable $values)
    {
        return $this->mutateArray($values->toArray());
    }

    /**
     * 型が不明な場合はそのまま
     *
     * @param mixed $value
     * @return mixed
     */
    protected function mutateUnknown($value)
    {
        return $value;
    }
}
