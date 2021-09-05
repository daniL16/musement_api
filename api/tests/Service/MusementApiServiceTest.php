<?php

namespace App\Tests\Service;

use App\Service\MusementApiService;
use App\Service\MusementCitiesService;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MusementApiServiceTest extends WebTestCase
{
    private MusementApiService $apiClient;

    public function setUp(): void
    {
        $this->apiClient = new MusementApiService();
    }

    public function testCitiesApi(){
        $citiesService = new MusementCitiesService($this->apiClient);
        $cities = $citiesService->getCities();
        /*
         * We expect an array with all the cities.
         */
        $this->assertIsArray($cities);
        $this->assertGreaterThan(0, $cities);
    }

    /**
     * Try to make a request to an endpoint that is not defined in our configuration
     * @throws GuzzleException
     */
    public function testInvalidEndpoint(){
        $this->expectException(InvalidArgumentException::class);
        $this->apiClient->sendRequest('test');
    }
}