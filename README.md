# ChargeMapTechnicalTest

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
- Swagger-UI will be available at <a href="http://localhost/docs">http://localhost/docs</a>
- You can run unit tests with that command
    ```shell
    docker exec php vendor/bin/phpunit tests
    ```
- If needed you can regen openapi doc
    ```shell
    docker exec php vendor/bin/openapi src -o public/docs/openapi.yaml
    ```

## Potential improvements

- Entrypoint with composer install
- Usage of interfaces
- Serialization components
- DDD