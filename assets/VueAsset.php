<?php

namespace app\assets;

use yii\web\AssetBundle;

class VueAsset extends AssetBundle
{
    public $sourcePath = '@app/web/vue';

    public $js = [
        'js/app.js',
        'js/chunk-vendors.js'
    ];

    public $css = [
      //  'css/app.css',
    ];
}
