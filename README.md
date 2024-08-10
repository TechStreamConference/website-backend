# How to get started?

## Prerequisites
- install Composer ([click here](https://getcomposer.org/))
- ```sh
  composer install
  ```
- copy `env` file to `.env` and set `CI_ENVIRONMENT = development` and set your database credentials

## Set up the Database
- ```sh
  php spark migrate
  ```
- If you want some example data:
  ```sh
  php spark db:seed MainSeeder
  ```
