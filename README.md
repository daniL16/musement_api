## Musement | Backend tech homework

Daniel López García | Serinsa

### Dev environment.

The environment has been mounted on 2 Docker containers, one for nginx and one for php.
To set up a dev environment just need to run `docker-compose up -d` in the root folder.

Api keys are provided in api/.env.

### Makefile.

A Makefile file is provided with the following rules:

```
 make build # Build containers and run them
 make tests # Run tests
 make code-analyse # Run phpStan
 make help # Show all available rules
```

### Get forecast for cities from Musement's API.

As part of this test is required develop an application tha  gets 
the list of the cities from Musement's API for each city gets the forecast
for the next 2 days using http://api.weatherapi.com 
and print to STDOUT 
"Processed city [city name] | [weather today] - [weather tomorrow]".    

This application can be executed running 
`docker-compose exec php bin/console musement:get-cities-forecast` 
or just `make get-cities-forecast`.

This run a command that make a get request to Musement's API for get the list
of cities. Once we got it, for each city a new command is created, 
and it will be in charge of make a request to weatherapi for get weather forecast. 
Results are printed to stdout.

### GitHub Actions.

Repository has an automated action when push is done. 
This action runs php-cs-fixer over src folder to fix our code to follow Symfony standard.

### Code Analyser.

In order to detect possible errors in the code, PHPStan(https://phpstan.org/) code analyser has been included.
It can be executed by running `docker-compose exec php vendor/bin/phpstan analyse -l 8 src tests` or `make code-analyse`.
This tool has 9 levels of strictness. By default, we run it with the higher, but you can modify it changing l param.
