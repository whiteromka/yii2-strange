<?php

namespace app\modules\shop;

use Yii;

/**
 * shop module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\shop\controllers';

    public $defaultRoute = 'category';

    public $layout = 'shop';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        $path = '@app/views/layouts';
        $this->setLayoutPath($path);
    }
}
