<?php

namespace Polass\Tests\Stubs;

use Polass\Enum\Enum as AbstractEnum;

class Enum extends AbstractEnum
{
    /**
     * @var string
     */
    const __default = 'FOO';

    /**
     * @var string
     */
    const FOO = 'foo';

    /**
     * @var string
     */
    const BAR = 'bar';
}
