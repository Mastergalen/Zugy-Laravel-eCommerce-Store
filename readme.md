# Zugy

Laravel project for Zugy eCommerce store.

https://myzugy.com

## Features
* Coupons
* Delivery Time Notifications
* Order status tracking
* Payment methods
  * Stripe
  * Paypal
  * Cash
  
## Docker

To start the Docker environment run

```
docker-compose up -d nginx mysql redis
```

Inside `.env` set `DB_HOST` and `REDIS_HOST`

```
DB_HOST=mysql

REDIS_HOST=redis
```

Connect to a container:

```
docker exec -it workspace bash
```

## Installation

Install composer dependencies:

```
composer install
```

Migrate Database tables

```
php artisan migrate
```

Seed the Database

```
php artisan db:seed
```

## Deployment Checklist

* Verify all API keys are working and are not test keys
* Verify database backups are working
* Product table should be synced with Algolia
* Redis is installed and running
* Following locales should be installed (check with `locale -a`):
  * it_IT.utf8
  * en_GB.utf8
* Run tests on production
* Ensure that Real Visitor IP is revealed by installing additional modules for Apache or nginx due to Cloudflare