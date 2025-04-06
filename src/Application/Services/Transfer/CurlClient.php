<?php

declare(strict_types=1);

namespace App\Application\Services\Transfer;

class CurlClient
{
    public function get(string $url): string|false
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
