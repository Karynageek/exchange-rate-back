# Exchange Rate Back

This readme file provides the setup instructions, and deployment process.

## How to Setup Locally

To set up the project locally, follow these steps:

1. Install PHP 8.1 if you need.

2. Clone the project from GitHub using the following command in the terminal:

   ```shell
   git clone git@github.com:Karynageek/exchange-rate-back.git
   ```

3. Run `cd exchange-rate-back`

4. Install the project dependencies by running the following command in the terminal, within the main folder of the project:

   ```shell
   composer install
   ```
5. Customize the configurations:
    - Make a copy of .env.example and rename it to .env.

   ```shell
   cp .env.example .env
   ```
    - Fill in the necessary values for local development in the .env file.

6. Clear the configuration cache by running the following command:

   ```shell
   php artisan config:clear
   ```
7. For local development create a Docker container using the command:

   ```shell
   docker-compose up -d --build
   ```

8. generate api key

   ```shell
   php artisan key:generate
    ```
   
9. Initialize the database

   ```shell
   php artisan migrate:fresh
   ```

## How to Run Tests
To run tests, perform the following steps:

1. Copy the .env.example file and rename it to .env.testing:

   ```shell
   cp .env.example .env.testing
   ```

2. Clear the configuration cache by running the following command:

   ```shell
   php artisan config:clear
   ```

3. To run tests, simply call:

   ```shell
   ./vendor/bin/phpunit
   ```
