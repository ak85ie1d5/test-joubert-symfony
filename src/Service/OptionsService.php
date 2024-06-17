<?php

namespace App\Service;

use App\Repository\OptionsRepository;

class OptionsService
{
    private OptionsRepository $optionsRepository;

    private string $apiKey;

    private string $apiUrl;

    private array $mnemonicCommodity;

    private string $mnemonicCurrency;

    public function __construct(OptionsRepository $optionsRepository)
    {
        $this->optionsRepository = $optionsRepository;
    }

    public function getApiKey(): string
    {
        if ($this->optionsRepository->findOneBy(['name' => 'api_key'])) {
            $this->apiKey = $this->optionsRepository->findOneBy(['name' => 'api_key'])->getValue()[0];
        }

        return $this->apiKey;
    }

    public function getApiUrl(): string
    {
        if ($this->optionsRepository->findOneBy(['name' => 'api_url'])) {
            $this->apiUrl = $this->optionsRepository->findOneBy(['name' => 'api_url'])->getValue()[0];
        }

        return $this->apiUrl;
    }

    public function getMnemonicCommodity(): array
    {
        if ($this->optionsRepository->findOneBy(['name' => 'mnemonic_commodity'])) {
            $this->mnemonicCommodity = $this->optionsRepository->findOneBy(['name' => 'mnemonic_commodity'])->getValue();
        }

        return $this->mnemonicCommodity;
    }

    public function getMnemonicCurrency(): string
    {
        if ($this->optionsRepository->findOneBy(['name' => 'mnemonic_currency'])) {
            $this->mnemonicCurrency =  $this->optionsRepository->findOneBy(['name' => 'mnemonic_currency'])->getValue()[0];
        }

        return $this->mnemonicCurrency;
    }
}