<?php

return [
    'mail' => [
        'host' => 'smtp.yandex.ru',
        'username' => '?',
        'password' => '?',
        'port' => '465',
        'encryption' => 'ssl',
    ],
    'yandexApiWeather' => [
        'url' => 'https://api.weather.yandex.ru/v2/informers',
        'key' => '?',
    ],
    'cryptoCompareApi' => [
        #https://min-api.cryptocompare.com/documentation?key=Price&cat=multipleSymbolsPriceEndpoint
        'url' => 'https://min-api.cryptocompare.com/data/', //price?fsym=ETH&tsyms=USD,EUR,RUB'
        //https://min-api.cryptocompare.com/data/ pricemulti?fsyms=BTC,ETH&tsyms=USD,EUR
    ]
];
