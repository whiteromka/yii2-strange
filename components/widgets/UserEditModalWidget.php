<?php

namespace app\components\widgets;

use yii\base\Widget;

class UserEditModalWidget extends  Widget
{
    public function run()
    {
        return $this->render('user-edit-modal');
    }
}