<?php

namespace Mirvan\IPPanel;

use Ippanel\Client;

class IPPanel extends Client
{
    public function __construct()
    {
        parent::__construct(config('services.ippanel.api_key'));
    }
}
