<?php

namespace app\models\query;

use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\Query;

class UserQuery extends ActiveQuery
{
    /**
     * @return UserQuery
     */
    public function adult()
    {
        $dateInPast = $this->getDateNYeasAgo(18);
        return $this->andWhere(['<', 'birthday', $dateInPast]);
    }

    /**
     * And where user has passport
     *
     * @param string $existPassport
     * @return UserQuery
     */
    public function andFilterWhereExistPassport(string $existPassport)
    {
        $subQuery = (new Query())->select([new Expression('1')])
            ->from('passport')
            ->where('user.id = passport.user_id');
        return $this->andWhere([$existPassport, $subQuery]);
    }

    /**
     * @param int $n
     * @return string
     */
    protected function getDateNYeasAgo(int $n)
    {
        $currentDate = date('Y-m-d');
        $arrDate = explode('-', $currentDate);
        $arrDate[0] = (int)$arrDate[0] - $n;
        return $dateInPast = implode('-', $arrDate);
    }
}