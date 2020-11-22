<?php

namespace app\assets;

use yii\web\AssetBundle;

class AjaxButtonsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/loader.css'
    ];

    public $js = [
        'js/ajaxButtons.js'
    ];

    public $depends = [
        AppAsset::class
    ];
}
