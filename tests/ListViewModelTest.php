<?php

namespace Polass\Tests;

use PHPUnit\Framework\TestCase;
use Polass\Fluent\Model;

class ListViewModelTest extends TestCase
{
    /**
     * `toArray()` のテスト
     *
     */
    public function testToArray()
    {
        $viewModel = new Stubs\ExtendedListViewModel(collect([ new Model ]), Stubs\ExtendedViewModel::class);
        $inner = new Stubs\ExtendedViewModel;

        $this->assertEquals(
            [ $inner->toArrayAnswer ], $viewModel->toArray()
        );
    }
}
