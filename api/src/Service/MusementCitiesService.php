<?php

namespace App\Service;

use GuzzleHttp\Exception\GuzzleException;

class MusementCitiesService
{

    public function __construct(
        private MusementApiService $apiService
    )
    {}

    /**
     * @return array
     * @throws GuzzleException
     */
    public function getCities(): array{
        return json_decode($this->apiService->sendRequest('cities')->getBody()->getContents(), true);
    }
}