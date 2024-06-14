<?php

namespace App\Service;

class GoldApiService
{
    private string $apiKey;
    private string $date = "";

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function sendRequestToApi(string $url)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => array(
                'x-access-token: ' . $this->apiKey,
                'Content-Type: application/json'
            )
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            throw new \Exception('Error: ' . $error);
        } else {
            return json_decode($response, true);
        }
    }
}