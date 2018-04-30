<?php

namespace Polass\Tests;

use DateTime;
use PHPUnit\Framework\TestCase;
use Illuminate\Support\Collection;
use Polass\ViewModel\Mutator;
use Polass\Tests\Stubs\Enum;

class MutetorTest extends TestCase
{
    /**
     * テストの準備
     *
     */
    public function setUp()
    {
        $this->enum = Enum::default();
        $this->date = new DateTime('2017-01-23');
    }

    /**
     * `getType()` のテスト
     *
     */
    public function testGetType()
    {
        $this->assertEquals(
            'Enum', (new Mutator)->getType($this->enum)
        );

        $this->assertEquals(
            'DateTime', (new Mutator)->getType($this->date)
        );

        $this->assertEquals(
            'Array', (new Mutator)->getType([ 'inner' ])
        );

        $this->assertEquals(
            'Arrayable', (new Mutator)->getType(collect([ 'inner' ]))
        );
    }

    /**
     * `mutate()` のテスト
     *
     */
    public function testMutate()
    {
        $this->assertEquals(
            $this->enum->value, (new Mutator)->mutate($this->enum)
        );

        $this->assertEquals(
            $this->date->format(DateTime::W3C), (new Mutator)->mutate($this->date)
        );

        $this->assertEquals(
            [ 'inner' ], (new Mutator)->mutate([ 'inner' ])
        );

        $this->assertEquals(
            [ $this->enum->value ], (new Mutator)->mutate([ $this->enum ])
        );

        $this->assertEquals(
            [ 'inner' ], (new Mutator)->mutate(collect([ 'inner' ]))
        );

        $this->assertEquals(
            [ $this->enum->value ], (new Mutator)->mutate(collect([ $this->enum ]))
        );
    }

    /**
     * `mutate()` の呼び出し元に変換器がある場合のテスト
     *
     */
    public function testMutateWithInvoker()
    {
        $this->assertEquals(
            'successful', (new Mutator(new Stubs\ViewModelWithMutatorMethod))->mutate($this->enum)
        );
    }
}
