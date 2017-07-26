<?php

namespace Polass\Tests\Stubs;

use DateTime;
use Polass\Tests\Stubs\ExtendedViewModel;

class ExtendedViewModelWithWrapper extends ExtendedViewModel
{
    /**
     * コンストラクタ
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->toArrayAnswer = [
            'wrapper' => $this->toArrayAnswer,
        ];
    }

    /**
     * 配列に変換する際にデータを加工
     *
     * @param array $data
     * @return array
     */
    public function wrap($data)
    {
        return [ 'wrapper' => $data ];
    }
}
