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

### ユーザー情報

**GET** api/users  
全てのユーザーを返す  
#### Response
```javascript
[{
    "id" : 1,
    "name" : "name",
    "email" : "xxx@example.com",
    "created_at" : "2019-12-12 08:01:24",
    "updated_at" : "2019-12-12 08:01:24",
 },
 {
    ...
 }]
```
**GET** api/user  
ユーザーを返す  
#### Response
```javascript
{
    "id" : {id},
    "name" : "name",
    "email" : "xxx@example.com",
    "created_at" : "2019-12-12 08:01:24",
    "updated_at" : "2019-12-12 08:01:24"
 }
```

**GET** api/users/{id}  
指定されたidのユーザーを返す  

**POST** api/users  
新規ユーザー登録  
#### Request
```javascript
{
    "name" : "name",
    "email" : "xxx@example.com",
    "password" : "password"
}
```
#### Response
```javascript
{api_token}
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

### 投稿情報

**GET** api/posts  
全投稿を返す  
#### Response
```javascript
[{
    "id" : 1,
    "user_id" : 2,
    "body" : "text",
    "created_at" : "1991-07-02 00:00:00",
    "updated_at" : "2018-10-05 00:00:00"
    "user": {
            "id": 2,
            "name": "username",
            "email": "email@example.net",
            "created_at": "2019-12-15 14:30:18",
            "updated_at": "2019-12-15 14:30:18"
        }
    "likes": [
        {
            "id": 2,
            "user_id": 14,
            "post_id": 2,
            "created_at": "2019-12-23 15:30:42",
            "updated_at": "2019-12-23 15:30:42"
        }
    ]
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
    "user": {
            "id": {user_id},
            "name": "username",
            "email": "email@example.net",
            "created_at": "2019-12-15 14:30:18",
            "updated_at": "2019-12-15 14:30:18"
        }   
 },
 {
    ...
}]
```

**POST** api/posts  
新規投稿を作成。作成後その投稿のidを返す。  
#### Request
```javascript
{
    "name" : {user_name},
    "body" : "text",
}
```
#### Response
```javascript
{ "id": 2}
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

### Login

***POST*** api/login
emailとpasswordでログインして、トークンを生成し直し渡す  
#### Request
```javascript
{
    "email" : "email@example.com",
    "password" : "password"
}
```
#### Response
```javascript
{api_token}
```

### いいね

**POST** api/posts/{post_id}/likes/{user_id}
いいねする

**DELETE** api/posts/{post_id}/likes/{user_id}
いいね取り消し


### ユーザーひとこと

**POST** api/users/{user}/comment  
ユーザーのひとことを追加する  

#### Request
```javascript
{ "comment": "hitokoto" }
```
### タグ  

***GET*** api/tags  
タグの一覧表示  
#### Response  
```javascript
[
    {
        "id": 1,
        "name": "php",
        "created_at": "2019-12-23 14:26:59",
        "updated_at": "2019-12-23 14:26:59",
        "post": [
            {
                "id": 1,
                "user_id": 19,
                "body": "Duck. 'Found IT,' the Mouse heard this, it.",
                "created_at": "1988-06-23 00:00:00",
                "updated_at": "1984-05-29 00:00:00",
                "likes_count": 0,
                "pivot": {
                    "tag_id": 1,
                    "post_id": 1
                }
            },
            {
```

***POST*** api/posts/{post_id}/tags  
送信されたタグと投稿を結びつける。登録されていなければ新規作成。  
#### Request
```javascript
{ "tags": ["php", "html", "css"] }
```

***GET*** api/tags/{tag_id}  
指定されたタグのついた投稿を全て返す。  
#### Response
```javascript
[
    {
        "id": 2,
        "name": "laravel",
        "created_at": "2019-12-23 14:28:03",
        "updated_at": "2019-12-23 14:28:03",
        "post": [
            {
                "id": 1,
                "user_id": 19,
                "body": "Duck. 'Found IT,' the Mouse heard this, it.",
                "created_at": "1988-06-23 00:00:00",
                "updated_at": "1984-05-29 00:00:00",
                "likes_count": 0,
                "pivot": {
                    "tag_id": 2,
                    "post_id": 1
                }
            },
```

***DELETE*** api/tags/{tag_id}
タグの削除  
