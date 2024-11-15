# ChargeMapTechnicalTest

I realised this technical test during the process of recruiting by ChargeMap. You can find the specifications in the PDF.
I let you be the judge of my completion of the specifications.

They judged that it wasn't enough for a senior backend developper position with dev-ops tasks also.
Their justification is that the level of code is not enough, it's missing components such as validators (not specified in the PDF).
Apparently you're supposed to read their minds.

I hope this can help anyone else that has to take it. Start with that and guess what else they may want.

## Requirements

- Docker
- Should work on any platform but have not been able to try it on Mac

## Install project

- Retrieve code base
    ```shell
    git clone git@github.com:BouyaGotcha/ChargeMapTechnicalTest.git
    ```
- Start app in docker
    ```shell
    docker compose up -d
    ```
- Install dependencies
    ```shell
    docker exec php composer install
    ```
- Run migrations
    ```shell
    docker exec php vendor/bin/doctrine-migrations migrations:migrate
    ```
  
## User guide

- Project will be available at <a href="http://localhost">http://localhost</a> 
- You can run unit tests with that command
    ```shell
    docker exec php vendor/bin/phpunit tests
    ```
- Swagger-UI will be available at <a href="http://localhost/docs">http://localhost/docs</a>
- If needed you can regen openapi doc
    ```shell
    docker exec php vendor/bin/openapi src -o public/docs/openapi.yaml
    ```

## Improvements

- Entrypoint with composer install
- Usage of interfaces
- Serialization components
- DDD
- More Unit testing
- Fixtures for unit testing
