<?php

namespace App\Command;

use App\Domain\Command\GetWeatherCommand;
use App\Service\MusementApiService;
use App\Service\MusementCitiesService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class GetForecastCommand extends Command
{
    protected static $defaultName = 'musement:get-cities-forecast';

    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
        parent::__construct();
    }

    /**
     * Get the list of the cities from Musement's API for each city gets the forecast for the next 2 days.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $cities = $this->getCities();
        } catch (GuzzleException $exception) {
            $output->writeln('Error while getting cities: '.$exception->getMessage());

            return Command::FAILURE;
        }

        foreach ($cities as $city) {
            $cityData = [
                'name' => $city['name'],
                'longitude' => $city['longitude'],
                'latitude' => $city['latitude'],
            ];
            $weatherCommand = (new GetWeatherCommand($output))->fromPayload($cityData);
            try {
                $this->messageBus->dispatch($weatherCommand);
            } catch (Exception $exception) {
                $output->writeln($exception->getMessage());

                return Command::FAILURE;
            }
        }

        return Command::SUCCESS;
    }

    /**
     * Get array of cities from Musement API.
     *
     */
    private function getCities(): array
    {
        $apiClient = new MusementCitiesService(new MusementApiService());

        return $apiClient->getCities();
    }
}
