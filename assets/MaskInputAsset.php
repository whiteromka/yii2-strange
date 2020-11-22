<?php

namespace app\assets;

use yii\web\AssetBundle;

class MaskInputAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        "https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js",
        "https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js",
        'js/maskDate.js'
    ];
    public $depends = [
        AppAsset::class
    ];
}
