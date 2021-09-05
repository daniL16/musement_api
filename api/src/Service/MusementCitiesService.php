<?php

namespace App\Service;

use GuzzleHttp\Exception\GuzzleException;

class MusementCitiesService
{

    public function __construct(
        private MusementApiService $apiService
    )
    {}

    public function getCities(): array{
        try{
            $apiResponse =  $this->apiService->sendRequest('cities')->getBody()->getContents();
            $cities = json_decode($apiResponse, true);
        }catch (GuzzleException){
            return [];
        }
        return $cities;
    }
}