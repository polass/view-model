<?php

namespace Polass\Tests\Stubs;

use DateTime;
use Polass\ViewModel\ViewModel;
use Polass\Tests\Stubs\Enum;

class ExtendedViewModel extends ViewModel
{
    /**
     * ViewModel の属性と`$attributes` の属性との対応関係
     *
     * @var array
     */
    protected $map = [
        'NULL' => 'null',
        'NUMBER' => 'number',
        'STRING' => 'string',
        'ENUM' => 'enum',
        'DATE' => 'date',
        'ARRAY.VALUE' => 'array',
        'ARRAY.FOO' => 'array.foo',
        'COLLECTION-FOO' => 'collection.foo',
        'COLLECTION-ENUM' => 'collection.enum',
        'COLLECTION-DATE' => 'collection.date',
        'UNDEFINED' => 'undefined',
    ];

    /**
     * テストで使う Enum インスタンス
     *
     * @var \Polass\Enum\Enum
     */
    public $enum;

    /**
     * テストで使う DateTime インスタンス
     *
     * @var \DateTime
     */
    public $date;

    /**
     * テストで使う Collection インスタンス
     *
     * @var \Illuminate\Support\Collection
     */
    public $collection;

    /**
     * `getAttributes()` の戻り値の期待値
     *
     * @var array
     */
    public $getAttributesAnswer;

    /**
     * `toArray()` の戻り値の期待値
     *
     * @var array
     */
    public $toArrayAnswer;

    /**
     * コンストラクタ
     *
     */
    public function __construct()
    {
        $this->enum = Enum::default();
        $this->date = new DateTime('2017-01-23');
        $this->collection = collect([
            'foo' => 'bar',
            'enum' => $this->enum,
            'date' => $this->date,
        ]);

        $this->attributes = [
            'null' => null,
            'number' => 123,
            'string' => 'hoge',
            'enum' => $this->enum,
            'date' => $this->date,
            'array' => [
                'foo' => 'bar',
            ],
            'collection' => $this->collection,
        ];

        $this->getAttributesAnswer = [
            'NULL' => null,
            'NUMBER' => 123,
            'STRING' => 'hoge',
            'ENUM' => $this->enum,
            'DATE' => $this->date,
            'ARRAY' => [
                'VALUE' => [ 'foo' => 'bar' ],
                'FOO' => 'bar',
            ],
            'COLLECTION-FOO' => 'bar',
            'COLLECTION-ENUM' => $this->enum,
            'COLLECTION-DATE' => $this->date,
            'UNDEFINED' => null,
        ];

        $this->toArrayAnswer = [
            'NULL' => null,
            'NUMBER' => 123,
            'STRING' => 'hoge',
            'ENUM' => 'foo',
            'DATE' => $this->date->format(DateTime::W3C),
            'ARRAY' => [
                'VALUE' => [ 'foo' => 'bar' ],
                'FOO' => 'bar',
            ],
            'COLLECTION-FOO' => 'bar',
            'COLLECTION-ENUM' => 'foo',
            'COLLECTION-DATE' => $this->date->format(DateTime::W3C),
            'UNDEFINED' => null,
        ];
    }
}
