# Local Food Nodes

# Dev environment prerequisite
* Install Composer
* Install Laravel Valet

#### Project
* Clone git repo
* Run `composer install` in project root directory or from inside vagrant
* Create folders named **sessions**, **views** and **cache** in **storage/framework**.
* Configure your .env (ask David)

### Building assets
We're using elixir, just run `npm run watch` in terminal. Before deploying run `npm run production` instead.

#### Problem with storage write permission
* php artisan cache:clear
* chmod -R 777 storage
* composer dump-autoload

# Testing
php artisan migrate --database='phpunit'
php artisan db:seed --database='phpunit'

# App development
Start tunnel with `valet share` and use generated url in app .env

# API's
There are multiple API's in use.
## Public API
Public API serves data to JS components on the site.
## Private API
The private API uses passport auth
## Statistics API
An Open API with calculated/aggregated data

# Notifications

Create notification "event" on "new order and new product"
On cron, create notifications per user

Hur veta när en notifikaiton är skickad?
## New product
    Create: when new product is created
    Send: Direct
    Send to: Users that follow a node
## New order
    Create: when order is placed
    Send: Direct
    Send to: User, producer, node admin
## Upcoming pickup
    Create: Same as order
    Send: 12h before, 1h before
    Send to: User with orders
## Next date
    Create: Dynamic
    Send: 3 days before
    Send to: User that follow a node