<?php

namespace App\Common;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class Request
{

    /**
     * @param string $base_uri
     * @param string $uri
     * @param string $method
     * @param array $data
     * @param array $queryParams
     * @return Response
     * @throws GuzzleException
     */
    public function sendRequest(string $base_uri, string $uri, string $method = 'GET', array $data = [], array $queryParams = []): Response
    {
        $client = new Client([
            'base_uri' =>  $base_uri,
            'headers' => [
                'Accept' => 'application/json',
            ],
            'query' => $queryParams
        ]);

        return $client->request($method, $uri, $data);
    }
}