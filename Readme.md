## RTL - The Mikko Test
A small command-line utility to help a fictional company determine the dates they need to pay salaries to their sales department.

I've managed to create a simple dockerized symfony backend service.

## System requirements

- Docker https://docs.docker.com/desktop/
- Composer https://getcomposer.org/

## Tool and Technologies

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



Thank you.



