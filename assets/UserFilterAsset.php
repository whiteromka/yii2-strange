<?php

namespace app\assets;

use yii\web\AssetBundle;

class UserFilterAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/loader.css'
    ];

    public $js = [
        'js/userFilter/userFilter.js',
        'js/userFilter/ajaxButtons.js'
    ];

    public $depends = [
        AppAsset::class
    ];
}