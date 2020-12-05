<?php

namespace app\assets;

use yii\web\AssetBundle;

class UserFilterAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [];

    public $js = [
        'js/userFilter.js'
    ];

    public $depends = [
        AppAsset::class
    ];
}
