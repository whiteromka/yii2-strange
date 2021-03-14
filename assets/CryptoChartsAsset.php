<?php

namespace app\assets;

use yii\web\AssetBundle;

class CryptoChartsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/charts.css'
    ];
    public $js = [
        '//cdn.amcharts.com/lib/4/core.js',
        '//cdn.amcharts.com/lib/4/charts.js',
        '//cdn.amcharts.com/lib/4/themes/animated.js',
        'js/crypto/charts.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
