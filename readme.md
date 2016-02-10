
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

    'String' => Illuminate\Support\Str::class,
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

    php artisan vendor:publish --tag='migrations' --force
    php artisan vendor:publish --tag='factories' --force
    php artisan vendor:publish --tag='seeds' --force

2. DatabaseSeeder.php

    $this->call('ShopSeeder');

3. Seed

    composer dump-autoload
    php artisan db:seed


# Testing



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
        
tests/_bootstrap.php

    require 'bootstrap/autoload.php';
    $app = require 'bootstrap/app.php';
    $app->loadEnvironmentFrom('.env.testing');
    $app->instance('request', new \Illuminate\Http\Request);
    $app->make('Illuminate\Contracts\Http\Kernel')->bootstrap();
    
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

run

    php ./vendor/bin/codecept run

# Roadmap

TODO: Replace hard-coded strings with language file (including validation messages)

TODO: Move cart validation & checks to models

TODO: Add message bag (Notifications)

TODO: Check stock on Product/Extra controller

TODO: Finish checkout process

TODO: Add callback (send order ID as encrypted string)

TODO: Pagination

