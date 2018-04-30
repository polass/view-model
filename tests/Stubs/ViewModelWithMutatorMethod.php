<?php

namespace Polass\Tests\Stubs;

use DateTime;
use Polass\ViewModel\ViewModel;
use Polass\Enum\Enum;

class ViewModelWithMutatorMethod extends ViewModel
{
    public function mutateEnum(Enum $value)
    {
        return 'successful';
    }
}
