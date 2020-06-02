<?php

namespace App\Service;

use FINDOLOGIC\Api\Client;
use FINDOLOGIC\Api\Config;

class FindologicApiService
{
    public function getClient(): Client
    {
        $config = new Config($_ENV['FINDOLOGIC_SERVICE_ID']);

        return new Client($config);
    }
}
