<?php

namespace App\Service;

use App\Common\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class MusementApiService
{

    private array $apiConfig = [
        'cities' => [
            'method' => 'GET',
            'uri' => '/cities',
        ],
    ];

    /**
     * @param string $api
     * @param array $data
     * @param array $queryParams
     * @return Response
     * @throws GuzzleException
     */
    public function sendRequest(string $api,  array $data = [], array $queryParams = []): Response
    {
        $uri = 'api/'.$_ENV['MUSEMENT_API_VERSION']. $this->apiConfig[$api]['uri'];
        $requestHandler = new Request();
        return $requestHandler->sendRequest($_ENV['MUSEMENT_API_URL'], $uri, $this->apiConfig[$api]['method'], $data, $queryParams);

    }
}