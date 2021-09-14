<?php

namespace Mirvan\IPPanel;

use IPPanel\Client;

class IPPanel extends Client
{
    public function __construct()
    {
        parent::__construct(config('services.ippanel.api_key'));
    }
}
