<?php

namespace Informatec\Validation\Rules;

use Informatec\Models\Major;
use Informatec\Models\User;
use Respect\Validation\Rules\AbstractRule;

class MajorAvailable extends AbstractRule
{
    public function validate($input)
    {
        return Major::where('id', $input)->count() === 0;
    }
}
