<?php

namespace Mirvan\IPPanel\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function configurationNotSet(): self
    {
        return new static('In order to send notifications via IPPanel you need to add credentials in the `ippanel.api_key` key of `config.services`.');
    }
}
