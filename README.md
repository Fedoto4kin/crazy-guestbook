# Crazy guestbook
<!-- ABOUT -->

This application is a Yii2 advanced platform build code-test according to the followed task

> You need to create a simple commenting system (front-end and administration area) with the Yii framework:
>
> Front-end: A person fills in a comment filed (makes a post) without logging in. The post appears in the comments feed.
>
> Administration area: the administrator logs in and sees the list of comments (content, date, etc.), 
> can edit the comment / delete it. 
> When a new comment was posted in front-end - administrator sees it in administrative area's list of comments updated in realtime 
> (web-sockets are used for this), also notification about new comment pops out.
>


<!-- GETTING STARTED -->
## Getting Started

### Prerequisites

* docker-compose
* docker 

In common case it will be installed and run like this way:

### Installation

* Clone the repo from github
```sh
git clone git@github.com:Fedoto4kin/crazy-guestbook.git crazy-guestbook
```
* Go into cloned project dir
```sh
cd crazy-guestbook
```
* Build docker images
```sh
docker-compose build
```
* Run containers
```sh
docker-compose up -d   
```
That's over with the environment. 
Next, we start to deploy the application.

* Enter into the container which serves an app, php-fpm. Run composer for install Yii and dependencies.
```sh
docker exec -it guestbook_phpfpm composer install
```
* Initialize the Yii project:
```sh
docker exec -it guestbook_phpfpm ./init
```

*When you run docker as root, the files generated into container may be not accessible for not-root user.*

* Configure your DB connection

`Note: if you run docker as root(sudo), you may need to change access rights for this file for edit `

if you run this docker images, it must be the same as this:
```php
# app/common/config/main-local.php

  'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=guestbook_db;port=5432;dbname=guestbook',
            'username' => 'admin',
            'password' => '12345',
            'charset' => 'utf8',
        ],

```

* Run migrations and create database tables
```sh
docker exec -it guestbook_phpfpm ./yii migrate
```
First migration, as well, will create the administrator user called admin with a very secret password 'admin'. 


That's almost the end.
* The finish step: run the websocker server. This case it's demonized.

```sh
docker exec -it guestbook_phpfpm nohup ./yii server/start > /dev/null 2>&1 & 
```


### Tests (Optional)

Coming... 

### Usage 

Front-end: http://127.0.0.1

Administration area http://127.0.0.1/admin <br>
*You can log in Administration area under admin user created with first migration*


### TO DO LIST

* Tests: unit, functional, acceptance
* Use room for socket 
* Docker user issue
* xdebug + docker


