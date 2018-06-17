# Local Food Nodes

### Get started with the dev environment
* Install VirtualBox (https://www.virtualbox.org)
* Install Composer
* Install Laravel Homestead

### Setup dev environment
* Follow the Homestead documentation to configure the vagrant box.
* Add dev.localfoodnodes.org to your hosts file.

#### Project
* Clone git repo
* Run `composer install` in project root directory or from inside vagrant
* Create cache folders named sessions, views and cache under storage/framework.
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
* Start ngrok with `./ngrok http -region=eu -hostname=app.localfoodnodes.org 192.168.10.10:80`


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