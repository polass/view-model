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
            'Enum', (new Mutator($this->enum))->getType()
        );

        $this->assertEquals(
            'DateTime', (new Mutator($this->date))->getType()
        );

        $this->assertEquals(
            'Array', (new Mutator([ 'inner' ]))->getType()
        );

        $this->assertEquals(
            'Arrayable', (new Mutator(collect([ 'inner' ])))->getType()
        );
    }

    /**
     * `mutate()` のテスト
     *
     */
    public function testMutate()
    {
        $this->assertEquals(
            $this->enum->value, (new Mutator($this->enum))->mutate()
        );

        $this->assertEquals(
            $this->date->format(DateTime::W3C), (new Mutator($this->date))->mutate()
        );

        $this->assertEquals(
            [ 'inner' ], (new Mutator([ 'inner' ]))->mutate()
        );

        $this->assertEquals(
            [ $this->enum->value ], (new Mutator([ $this->enum ]))->mutate()
        );

        $this->assertEquals(
            [ 'inner' ], (new Mutator(collect([ 'inner' ])))->mutate()
        );

        $this->assertEquals(
            [ $this->enum->value ], (new Mutator(collect([ $this->enum ])))->mutate()
        );
    }
}
