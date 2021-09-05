<?php

namespace App\Common;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class Request
{
    /**
     * Send API request using Guzzle Client.
     *
     * @throws GuzzleException
     */
    public function sendRequest(string $base_uri, string $uri, string $method = 'GET', array $data = [], array $queryParams = []): Response
    {
        $client = new Client([
            'base_uri' => $base_uri,
            'headers' => [
                'Accept' => 'application/json',
            ],
            'query' => $queryParams,
        ]);

        return $client->request($method, $uri, $data);
    }
}
