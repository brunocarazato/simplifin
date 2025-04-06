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

    public function post(string $url, array $data): string|false
    {
        $payload = json_encode($data);

        $curl = curl_init($url);

        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload)
            ]
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
