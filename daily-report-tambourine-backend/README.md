# daily-report-tambourine

> Daily Report Website

## Build Setup

``` bash
# install dependencies
$ npm run install

# serve with hot reload at localhost:3000
$ npm run dev

# build for production and launch server
$ npm run build
$ npm run start

# generate static project
$ npm run generate
```

For detailed explanation on how things work, check out [Nuxt.js docs](https://nuxtjs.org).

## Docker Setup

move project root.

```bash
$ cd internship-dailyreport-doki/daily-report-tambourine-backend
```

copy .env

```bash
# copy
$ cp .env.example .env

$ vi .env
```

edit .env

```.env
APP_NAME=daily-report-tambourine-backend

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=local_database
DB_USERNAME=root
DB_PASSWORD=
```

create volume

```bash
$ docker volume create --name postgres_data
```

create container & start

```bash
$ docker-compose up -d
```

generate application key

```bash
# enter the container
$ docker-compose exec php bash

$ composer install

# generate application key
$ php artisan key:generate
```
