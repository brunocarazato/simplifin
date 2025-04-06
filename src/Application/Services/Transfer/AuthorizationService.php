<?php

declare(strict_types=1);

namespace App\Application\Services\Transfer;

class AuthorizationService
{
    public function __construct(private CurlClient $client) {}

    public function isAuthorized(): bool
    {
        $response = $this->client->get('https://util.devi.tools/api/v2/authorize');

        if ($response === false) {
            return false;
        }

        $data = json_decode($response, true);

        return isset($data['data']) && ($data['data']['authorization'] ?? '') === true;
    }
    
}