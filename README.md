# daily-report-tambourine

> Daily Report Website

## Build Setup

``` bash
# install dependencies
$ npm run install

# serve with hot reload at localhost:3313
$ npm run dev

# build for production
$ npm run build
```

For detailed explanation on how things work, check out [Nuxt.js docs](https://nuxtjs.org).

## Docker Setup

copy .env

```bash
# copy
$ cp .env.example .env
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

database migration (with seeds)

```bash
# in php container (after execution docker-compose exec php bash)
$ php artisan migrate --seed
```

## API DOCUMENT

### USERS

**GET** api/users  
全てのユーザーを返す  
#### Response
```javascript
[{
    "id" : 1,
    "name" : "name",
    "email" : "xxx@example.com",
    "email_verified_at" : "2019-12-12 08:01:24",
    "created_at" : "2019-12-12 08:01:24",
    "updated_at" : "2019-12-12 08:01:24",
    "api_token" : "token"
 },
 {
    ...
 }]
```
**GET** api/users  
ユーザーを返す  
#### Response
```javascript
{
    "id" : 1,
    "name" : "name",
    "email" : "xxx@example.com",
    "email_verified_at" : "2019-12-12 08:01:24",
    "created_at" : "2019-12-12 08:01:24",
    "updated_at" : "2019-12-12 08:01:24",
    "api_token" : "token"
 }
```

**POST** api/users  
新規ユーザー登録  
#### Request
```javascript
{
    "name" : "name",
    "email" : "xxx@example.com",
}
```

**PUT/PATCH** api/users/{user_id}  
ユーザー情報の更新  
#### Request
```javascript
{
    "name" : "name",
    "email" : "xxx@example.com",
    "password" : "password"
}
```

**DELETE** api/users/{user_id}  
ユーザー情報の削除  

### POSTS


**GET** api/posts/{user_id}  
全投稿を返す  
#### Response
```javascript
[{
    "id" : 1,
    "user_id" : {user_id},
    "body" : "text",
    "created_at" : "1991-07-02 00:00:00",
    "updated_at" : "2018-10-05 00:00:00"
 },
 {
    ...
}]
```

**GET** api/posts/{user_id}  
選択したユーザーの全投稿を返す  
#### Response
```javascript
[{
    "id" : 1,
    "user_id" : {user_id},
    "body" : "text",
    "created_at" : "1991-07-02 00:00:00",
    "updated_at" : "2018-10-05 00:00:00"
 },
 {
    ...
}]
```

**POST** api/posts  
新規投稿を作成  
#### Request
```javascript
{
    "user_id" : {user_id},
    "body" : "text",
}
```
**PUT/PATCH** api/posts/{post_id}  
投稿を更新  
#### Request
```javascript
{
    "user_id" : {user_id},
    "body" : "text",
}
```

**DELETE** api/posts/{post_id}  
投稿を削除  