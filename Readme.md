## RTL - The Mikko Test
A small command-line utility to help a fictional company determine the dates they need to pay salaries to their sales department.

I've managed to create a simple dockerized symfony backend service.

## Application requirement
[Requirement](Requirements.md)

## System requirements

- Docker https://docs.docker.com/desktop/
- Composer https://getcomposer.org/

## Tool and Technologies
- `symfony/console` for the CLI
- `league/csv` for CSV file handling
- `nesbot/carbon` for datetime 
- `monolog/monolog` for logger


- `phpunit/phpunit` for testing
- `phpstan/phpstan` and  `friendsofphp/php-cs-fixer` for coding standards

## Project setup
1. Setup the application via `make setup`
2. Start the application via `make start`
3. Generate payroll via `make generate-payroll`
    - filename is optional parameter default to `payroll_{YEAR}` 

### Additional commands
- Run the tests
```bash
make tests
```
- Run the quality assurance suite
```bash
make qa
```

- Stop the application containers
```bash
make stop
```

- Restart the application containers
```bash
make restart
```

- Destroy the application containers
```bash
make destroy
```

## Todo
I managed to finish this application in a short time frame, There are few things to be improved if I have more time.

- Functional tests to be written
- My docker image have php 8, I did not use any PHP 8 features yet
- as this application is simple cli, I used `SingleCommandApplication` boot the application, it would be nice if i boot the application in the symfony kernel.  

Thank you.



