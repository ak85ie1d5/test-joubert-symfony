<?php

namespace App\Service;

use App\Repository\OptionsRepository;
use Exception;

class GoldApiService
{
    private OptionsService $optionsService;

    private string $date = "";

    public function __construct(OptionsService $optionsService)
    {
        $this->optionsService = $optionsService;
    }

    /**
     * @throws Exception
     */
    public function sendRequestToApi(string $url)
    {
        if ($this->optionsService->getApiKey() != []) {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTPHEADER => array(
                    'x-access-token: ' . $this->optionsService->getApiKey(),
                    'Content-Type: application/json'
                )
            ));

            $response = curl_exec($curl);
            $error = curl_error($curl);

            curl_close($curl);

            if ($error) {
                throw new Exception('Error: ' . $error);
            } else {
                return json_decode($response, true);
            }
        } else {
            throw new Exception('Error: API key not found.');
        }
    }
}
