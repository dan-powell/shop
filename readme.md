
# WIP

This software is pre-alpha, don't bother to use it just yet...

# Install

1.

    $ composer require dan-powell/shop

2. config/app.php

    DanPowell\Shop\ShopServiceProvider::class,
    AlfredoRamos\ParsedownExtra\ParsedownExtraServiceProvider::class,
    Baum\Providers\BaumServiceProvider::class,
    Ignited\LaravelOmnipay\LaravelOmnipayServiceProvider::class
    
Aliases

    'Str' => Illuminate\Support\Str::class,
    'Markdown'  => AlfredoRamos\ParsedownExtra\Facades\ParsedownExtra::class,
    'Omnipay' => Ignited\LaravelOmnipay\Facades\OmnipayFacade::class


3. publish assets

    php artisan vendor:publish --tag='migrations'
    
    php artisan vendor:publish --tag='config'
    
    php artisan vendor:publish --provider='AlfredoRamos\ParsedownExtra\ParsedownExtraServiceProvider' --force

4. migrations

    php artisan migrate

5. Add user

    php artisan shop:adduser <username> <password>


# Updating


3. publish assets

    php artisan vendor:publish --tag='migrations'
    php artisan vendor:publish --tag='admin'

4. migrations

    php artisan migrate


# Seeding

1. publish

    php artisan vendor:publish --tag='dev' --force

2. DatabaseSeeder.php

    $this->call('ShopSeeder');

3. Seed

    composer dump-autoload
    php artisan db:seed


# Testing

Publish those assets

    php artisan vendor:publish --tag='tests' --force


config/database.php

    'testing' => [
        'driver'    => 'mysql',
        'host'      => 'localhost',
        'database'  => 'shop_testing',
        'username'  => 'homestead',
        'password'  => 'secret',
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
        'strict'    => false,
    ],
        

test/functional.suite.yml

    modules:
      enabled:
        - Laravel5:
            environment_file: .env.testing


.env.testing

    APP_ENV=testing
    APP_DEBUG=true
    APP_KEY=AqBqHv6GYO2PSIY3PIVO3o4zdcKovDdN
    
    BASE_URL=http://shop.dev
    
    DB_HOST=localhost
    DB_DATABASE=shop_testing
    DB_USERNAME=homestead
    DB_PASSWORD=secret
    
    CACHE_DRIVER=file
    SESSION_DRIVER=file

Migrate

    php artisan migrate --database=testing

Run

    php ./vendor/bin/codecept run



# Roadmap

TODO: Replace hard-coded strings with language file (including validation messages)

TODO: Finish checkout process

TODO: Add callback (send order ID as encrypted string)

TODO: Pagination

