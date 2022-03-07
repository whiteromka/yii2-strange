Install via Composer
Clone(or copy) this project in your computer.

If you do not have Composer, you may install it by following the instructions at getcomposer.org.

### INSTALATION AND CONFIGURATION
##You can then install this project template using the following command:
<code>
    composer install
</code>

##Then in folder 'config' create file 'db-local.php' with next code:
<code>
    <?php
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=<your DB>',
        'username' => '<your user>',
        'password' => '<your password>',
        'charset' => 'utf8',
    ];
</code>

##Then in folder 'config' create file 'params-local.php' with next code:
<code>
    <?php
    return [
        'mail' => [
            'host' => 'smtp.yandex.ru',
            'username' => '<your user>',
            'password' => '<your password>',
            'port' => '465',
            'encryption' => 'ssl',
        ],
        'yandexApiWeather' => [
            'url' => 'https://api.weather.yandex.ru/v2/informers',
            'key' => '<your key>',
        ],
        'cryptoCompareApi' => [
            'key' => '<your key>',
            'url' => 'https://min-api.cryptocompare.com/data/',
        ]
    ];
</code>

### CONSTRUCTION AND FILLING DB
## First roll dump in in folder 'config'.

## Then use command
<code>
    php yii migrate/up
</code>

## Then use command
<code>
    php yii app/fill-db
</code>

## Then use command
<code>
    php yii shop/fill
</code>

App is ready! Done!

### TESTS
How to use Codeception in project
Start test command example:
<code>
    vendor/bin/codecept run unit faker/UserFakerTest
</code>

Create test command example:
<code>
    vendor/bin/codecept generate:test unit faker/PassportFakerTest
</code>