<?php

namespace Polass\Tests;

use PHPUnit\Framework\TestCase;

class ViewModelTest extends TestCase
{
    /**
     * `getAttributes()` のテスト
     *
     */
    public function testGetAttributes()
    {
        $viewModel = new Stubs\ExtendedViewModel;

        $this->assertEquals(
            $viewModel->getAttributesAnswer, $viewModel->getAttributes()
        );
    }

    /**
     * `toArray()` のテスト
     *
     */
    public function testToArray()
    {
        $viewModel = new Stubs\ExtendedViewModel;

        $this->assertEquals(
            $viewModel->toArrayAnswer, $viewModel->toArray()
        );
    }

    /**
     * `wrap()` のテスト
     *
     */
    public function testWrap()
    {
        $viewModel = new Stubs\ExtendedViewModelWithWrapper;

        $this->assertEquals(
            $viewModel->toArrayAnswer, $viewModel->toArray()
        );
    }
}
