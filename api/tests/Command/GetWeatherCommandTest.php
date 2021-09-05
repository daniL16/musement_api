<?php

namespace App\Tests\Command;

use App\Domain\Command\GetWeatherCommand;

use App\Domain\CommandHandler\GetWeatherCommandHandler;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Output\OutputInterface;

class GetWeatherCommandTest extends WebTestCase
{

    private OutputInterface $output;
    private GetWeatherCommandHandler $commandHandler;

    public function setUp(): void
    {
        $this->output = $this->getMockBuilder(OutputInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->commandHandler = new GetWeatherCommandHandler();
    }

    public function provider(): array
    {
        return [
            ['city' => 'Granada', 'latitude' => 37.18, 'longitude' => -3.6 ],
        ];
    }

    public function providerInvalidPayload(): array
    {
        return [
            ['city' => 'Nowhere', 'latitude' => 0 , 'longitude' => 'ERROR'],
            ['city' => 'Nowhere', 'longitude' => 0, 'latitude' => 'NA'],
            ['city' => '', 'longitude' => 0, 'latitude' => 0],
        ];
    }

    public function providerInvalidCoordinates(): array{
        return [
            ['city' => 'Mars', 'latitude' => 12225522, 'longitude' => -1222 ]
        ];
    }

    /**
     * @dataProvider provider
     * @param string $city
     * @param float $latitude
     * @param float $longitude
     * @throws GuzzleException
     */
    public function testGetWeather(string $city, float $latitude, float $longitude): void {
        $data = [ 'name' => $city, 'latitude' => $latitude, 'longitude' => $longitude];

        $command = new GetWeatherCommand($this->output);
        $command->fromPayload($data);
        $handler = $this->commandHandler;
        $forecast = $handler($command);
        /*
         * We must obtain an array with DAYS_FORECAST rows.
         */
        $this->assertIsArray($forecast);
        $this->assertCount($handler::DAYS_FORECAST, $forecast);
        $this->assertArrayHasKey('condition',$forecast[0]);
    }

    /**
     * @dataProvider providerInvalidCoordinates
     * @param string $city
     * @param float $latitude
     * @param float $longitude
     * @throws GuzzleException
     */
    public function testInvalidCoordinates(string $city, float $latitude, float $longitude){
        $this->expectExceptionCode(400);
        $data = [ 'name' => $city, 'latitude' => $latitude, 'longitude' => $longitude];
        $command = new GetWeatherCommand($this->output);
        $command->fromPayload($data);
        $handler = $this->commandHandler;
        $handler($command);
    }

    /**
     * @dataProvider providerInvalidPayload
     * @param string $city
     * @param float $latitude
     * @param float $longitude
     */
    public function testInvalidPayload(mixed $city, mixed $latitude, mixed $longitude){
        $data = [
            'name' => $city,
            'latitude' => $latitude,
            'longitude' => $longitude
        ];
        $this->expectException(InvalidArgumentException::class);
        $command = new GetWeatherCommand($this->output);
        $command->fromPayload($data);
    }

    /**
     * @dataProvider provider
     * @param string $city
     * @param float $latitude
     * @param float $longitude
     */
    public function testValidPayload(string $city, float $latitude, float $longitude){
        $data = [
            'name' => $city,
            'latitude' => $latitude,
            'longitude' => $longitude
        ];
        $command = new GetWeatherCommand($this->output);
        $command->fromPayload($data);
        $this->assertIsObject($command);
    }
}