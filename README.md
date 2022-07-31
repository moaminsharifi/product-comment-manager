**Table of content**
- [Product Comment Manager](#product-comment-manager)
    - [IncrementalWarehouse Definition](#incrementalwarehouse-definition)
      - [implementations of Warehouse](#implementations-of-warehouse)
  - [Project Architecture](#project-architecture)
    - [Backend](#backend)
    - [Database](#database)
    - [Redis](#redis)
  - [Docker Compose Architecture](#docker-compose-architecture)
  - [Models and Database structure](#models-and-database-structure)
  - [Backend Architecture](#backend-architecture)
    - [Solving I/O write with `Warehouse`s](#solving-io-write-with-warehouses)
      - [Backend API docs](#backend-api-docs)
  - [Run project with docker compose](#run-project-with-docker-compose)
    - [build with docker-compose](#build-with-docker-compose)
    - [up with docker-compose](#up-with-docker-compose)
    - [connect to containers](#connect-to-containers)


# Product Comment Manager
In here, I want to dive in different aspect of project. from System needed to Architectures and how to deploy it.
The project is about a system which:
- have `User`, `Product` and `Comment`
- `User` can sing up and get token to access to api
- `User` can add new `Product`   (see more in api part)[#]
- User can add new `Comment` for `Product`, if `Product` not exist then create new one and `User` only can add 2 `Comment` per each `Product`
- A `IncrementalWarehouse` to save comment count in it (Yaml, Json, Redis and etc)

---
### IncrementalWarehouse Definition
`IncrementalWarehouse` or `Warehouse` is place `Comment` count for each product save like `productName => commentCount`
`Warehouse` implements base on `IncrementalWarehouseInterface` so each implementations at least have `increment` and `get` function.
```
<?php

namespace App\Contracts;

interface IncrementalWarehouseInterface
{
    public function increment(string $key);

    public function get(string $key);
}
```
There is also (config/warehouse.php)[backend/config/warehouse.php] file for config which type of `Warehouse` you need and then with `WarehouseServiceProvider` bind to Service container.
#### implementations of Warehouse
- `KeyValueYMLStyleWarehouse` : save in yml style
- `JsonWarehouse` : save in json style
- `RedisWarehouse` : save with redis container

Please note, for json and yml one better to bind file to docker, You can change it with `WAREHOUSE_JSON_FULL_PATH` and `WAREHOUSE_YML_FULL_PATH` in docker-compose `.env` file.


*For Checking  `User`, `Product` and `Comment` check (Models and Database)[#]*

## Project Architecture 
project based on docker compose all in one project style. so all files you need besides docker-compose.yml is in same repo.
there is 3 services:

- backend
- database
- redis (there no dir for it  right now)

```bash
├── assets
├── backend
│   ├── app
│   ├── bootstrap
│   ├── build
│   ├── config
│   ├── database
│   ├── docs
│   ├── framework
│   ├── lang
│   ├── public
│   ├── resources
│   ├── routes
│   ├── storage
│   ├── tests
│   └── vendor
├── db
└── _docker
    ├── backend
    └── db

```

### Backend
I setup laravel 9.19 version for this project with serving with `laravel/octane` on port `8000`.
also there is tests in `backend/tests/`

### Database
Due to same protocol and better performance I choice mariadb over mysql, for more see [Difference Between MySQL and MariaDB](https://www.geeksforgeeks.org/difference-between-mysql-and-mariadb/)
### Redis
for warehouse implementation I use redis to save information.
## Docker Compose Architecture
Here is schema of whole system under docker compose:
![System Design with Nginx for production](/assets/System%20Design%20with%20Nginx%20for%20production.png)


## Models and Database structure
![](assets/Database-diagram.png)

## Backend Architecture
Decoupling in Controller and Model with Service and Repository Pattern 
![](assets/Request%20Lift%20Cycle.png)

### Solving I/O write with `Warehouse`s
For solving `Warehouse` I/O I use job queue, when user want to create new comment I create new `IncrementCommentOfProductJob` and due to $warehouse instance backend increment `Comment` count for a `Product`

**be careful when you test it.**

#### Backend API docs
there is automatic api documentation generated with scribe under `backend/docs` and you can use them, `openapi.yaml` and `collection.json` for post man

## Run project with docker compose
### build with docker-compose
*for first time need to create network with `docker network create product-comment-manager`*
```bash
docker compose build
```
### up with docker-compose

```bash
docker compose up
```
### connect to containers
```bash
docker exec -ti CONTAINER_NAME sh
```
then you can run tests and any other things
