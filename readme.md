
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
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ],
        
phpunit.xml

    <testsuite name="ShopIntegration">
        <directory>./tests/Shop/Integration</directory>
    </testsuite>
    <testsuite name="ShopUnit">
        <directory>./tests/Shop/Unit</directory>
    </testsuite>
    <testsuite name="ShopApi">
        <directory>./tests/Shop/Api</directory>
    </testsuite>

    <php>
        <env name="DB_CONNECTION" value="testing"/>
    </php>
    
run

    phpunit
    
    phpunit --testsuite ShopIntegration
