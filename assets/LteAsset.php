<?php

namespace app\assets;

use yii\web\AssetBundle;

class LteAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];

    public $js = [
        'lte/js/common.js',
        'https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}