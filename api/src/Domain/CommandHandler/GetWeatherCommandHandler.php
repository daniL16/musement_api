<?php

namespace App\Domain\CommandHandler;

use App\Domain\Command\GetWeatherCommand;
use App\Service\ApiWeatherService;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GetWeatherCommandHandler implements MessageHandlerInterface
{
    public const DAYS_FORECAST = 2;

    /**
     * Get the weather forecast for a given city through its coordinates for the next n days.
     * Result is printed in console.
     *
     * @throws GuzzleException
     */
    public function __invoke(GetWeatherCommand $command): array
    {
        $coordinates = $command->getCoordinates();
        try {
            $apiWeatherClient = new ApiWeatherService();
            $forecast = $apiWeatherClient->getWeatherForecast($coordinates['latitude'], $coordinates['longitude'], self::DAYS_FORECAST);
            $forecastString = $this->buildForecastString($forecast);
            $command->getOutput()?->writeln('Processed city '.$command->getCityName().' | '.$forecastString);

            return $forecast;
        } catch (GuzzleException $exception) {
            $command->getOutput()?->writeln('Error: '.$exception->getMessage());
            throw $exception;
        }
    }

    /**
     * Format forecast as condition1 - condition2.
     */
    private function buildForecastString(array $forecast): string
    {
        $forecastString = '';
        foreach ($forecast as $key => $forecastDay) {
            $forecastString .= $forecastDay['condition'];
            if ($key < count($forecast) - 1) {
                $forecastString .= ' - ';
            }
        }

        return $forecastString;
    }
}
