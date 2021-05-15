<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic - Strange Project</h1>
    <br>
</p>


INSTALLATION
------------

### Install via Composer

Clone(or copy) this project in your computer.


If you do not have [Composer](http://getcomposer.org/), you may install it by following the instructions
at [getcomposer.org](http://getcomposer.org/doc/00-intro.md#installation-nix).

You can then install this project template using the following command:

~~~
composer install
~~~

Then in folder 'config' create file 'db-local.php' with next code:
~~~
<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=<your DB>',
    'username' => '<your user>',
    'password' => '<your password>',
    'charset' => 'utf8',
];
~~~

Then you can run command that create tables, and fills DB: (OR use dump in config folder)

~~~
php yii migrate/up
php yii app/fill-db
~~~

Done!


TESTS
------------

### How to use Codeception in project
Start test command example:
~~~
vendor/bin/codecept run unit faker/UserFakerTest
~~~

Create test command example:
~~~
vendor/bin/codecept generate:test unit faker/PassportFakerTest
~~~


