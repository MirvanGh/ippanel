<?php

namespace Mirvan\IPPanel\Facades;

use Illuminate\Support\Facades\Facade;

class IPPanel extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'IPPanel';
    }
}
