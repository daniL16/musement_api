<?php

namespace App\Service;

use App\Common\Request;
use GuzzleHttp\Exception\GuzzleException;

class ApiWeatherService
{
    /**
     * @throws GuzzleException
     */
    public function getWeatherForecast(float $latitude, float $longitude, int $days = 1): array
    {
        $queryParams = [
            'key' => $_ENV['API_WEATHER_KEY'],
            'q' => $latitude.','.$longitude,
            'days' => $days,
        ];

        $requestHandler = new Request();
        $response = $requestHandler->sendRequest($_ENV['API_WEATHER_URL'], 'v1/forecast.json', 'GET', [], $queryParams);
        $response = json_decode($response->getBody()->getContents(), true)['forecast']['forecastday'];
        $forecast = [];
        foreach ($response as $day) {
            $forecast[] = ['date' => $day['date'], 'condition' => $day['day']['condition']['text']];
        }

        return $forecast;
    }
}
