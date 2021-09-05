<?php

declare(strict_types=1);

namespace App\Domain\Command;

use App\Model\Command;
use InvalidArgumentException;
use Symfony\Component\Console\Output\OutputInterface;

class GetWeatherCommand extends Command
{

    private float $longitude;
    private float $latitude;
    private string $cityName;

    public function __construct(private OutputInterface $output){}

    public function fromPayload(array $payload): self
    {
        $this->assertIsValidPayload($payload);
        $this->longitude = $payload['longitude'];
        $this->latitude = $payload['latitude'];
        $this->cityName = $payload['name'];
        return $this;
    }

    /**
     * Check that longitude and latitude are floats
     * @param array $payload
     */
    public function assertIsValidPayload(array $payload): void
    {
        if(!is_float($payload['longitude'])){
            throw new InvalidArgumentException('Longitude value must be a float');
        }
        if(!is_float($payload['latitude'])){
            throw new InvalidArgumentException('Latitude value must be a float');
        }
        if(empty($payload['name'])){
            throw new InvalidArgumentException('City name is required');
        }
    }

    /**
     * @return string
     */
    public function getCityName(): string{
        return $this->cityName;
    }

    /**
     * @return array
     */
    public function getCoordinates(): array{
        return ['latitude' => $this->latitude, 'longitude' => $this->longitude];
    }

    /**
     * @return OutputInterface
     */
    public function getOutput(): OutputInterface{
        return $this->output;
    }
}