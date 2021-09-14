<?php

namespace Mirvan\IPPanel\Exceptions;

use Exception;

class CouldNotSendNotification extends Exception
{
    public static function mustSetReference()
    {
        return new static("You need to set Reference with 'routeNotificationForIPPanel()' in your model or 'reference' in your notification");
    }
    public static function mustSetOriginator()
    {
        return new static("You need to set Originator with 'ippanelOriginator()' in your model or 'originator' in your notification");
    }

    public static function serviceRespondedWithAnError($response)
    {
        return new static("IPPanel service responded with an error: {$response}'");
    }

    public static function httpClientRespondedWithAnError($response)
    {
        return new static("IPPanel Http Client service responded with an error: {$response}'");
    }
}
