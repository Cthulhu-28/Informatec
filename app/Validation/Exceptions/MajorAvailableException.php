<?php

namespace Informatec\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class MajorAvailableException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'The code is already in use',
        ],
    ];
}
