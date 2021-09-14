<?php

namespace Mirvan\IPPanel\Exceptions;

use Exception;

class InvalidMessage extends Exception
{
    public static function invalidReference(string $reference): self
    {
        return new static("The reference on the IPPanel message may only contain 1 - 32 alphanumeric characters. Was given '{$reference}'");
    }

    public static function invalidOriginator(string $originator): self
    {
        return new static("The originator on the IPPanel message may only contain 1 - 11 characters. Was given '{$originator}'");
    }
}
