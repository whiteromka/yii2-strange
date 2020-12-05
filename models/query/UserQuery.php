<?php

namespace app\models\query;

use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    /**
     * @return UserQuery
     */
    public function adult()
    {
        $currentDate = date('Y-m-d');
        $arrDate = explode('-', $currentDate);
        $arrDate[0] = (int)$arrDate[0] - 18; // 18 лет назад
        $dateInPast = implode('-', $arrDate);

        return $this->andWhere(['<', 'birthday', $dateInPast]);
    }
}