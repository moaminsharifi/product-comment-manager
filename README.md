**Table of content**

# product comment manager
php artisan make:model User -rfmsR --test
php artisan make:model Product -rfmsR --test
php artisan make:model Comment -rfmsR --test
php artisan make:model ProductComment -mp
php artisan make:model UserComment -mp
ProductComment

php artisan migrate:fresh
## Database 
![](assets/Database-diagram.png)
## Project Architecture
![System Design with Nginx for production](/assets/System%20Design%20with%20Nginx%20for%20production.png)
## Decoupling in Controller and Model with Service and Repository Pattern
![](assets/Request%20Lift%20Cycle.png)
## Tests

## Run project with docker compose

## 