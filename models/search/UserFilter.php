<?php

namespace app\models\search;

use Exception;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;
use yii\helpers\ArrayHelper;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserFilter extends User
{
    /** @var string - Date from this date */
    public $from_date;

    /** @var string - Date before this date */
    public $to_date;

    /** @var bool */
    public $exist_passport;

    /** @var string */
    public $passport_country;

    /** @var string */
    public $passport_city;

    const PASSPORT_EXIST = 1;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'surname', 'birthday', 'created_at', 'updated_at', 'gender', 'status'], 'safe'],
            [['from_date', 'to_date', 'exist_passport', 'passport_country', 'passport_city'], 'safe']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $old = parent::attributeLabels();
        $new = [
            'exist_passport' => 'Паспорт',
            'passport_country' => 'Страна',
            'passport_city' => 'Город'
        ];
        return ArrayHelper::merge($old, $new);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws Exception
     */
    public function search($params)
    {
        $query = User::find()->joinWith('passport');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => ArrayHelper::getValue($params, 'page_size', 20),
            ],
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        /** Search in user */
        $query->andFilterWhere([
            'id' => $this->id,
            'gender' => $this->gender,
            'status' => $this->status,
            'birthday' => $this->birthday,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['between', 'birthday', $this->from_date, ($this->to_date ?? $this->from_date)]);

        /** Search in passport */
        if ($this->existPassportOnlyOneChecked()) {
            $isExist = ArrayHelper::getValue($this->exist_passport, 0) == self::PASSPORT_EXIST;
            $existOrNot = $isExist ? 'exists' : 'not exists';
            $query->andFilterWhereExistPassport($existOrNot);
        }

        $query->andFilterWhere(['like', 'passport.country', $this->passport_country]);
        $query->andFilterWhere(['like', 'passport.city', $this->passport_city]);

        return $dataProvider;
    }

    /**
     * Return true if checked one of two checkboxes
     *
     * @return bool
     */
    protected function existPassportOnlyOneChecked() : bool
    {
        return $this->exist_passport && (count($this->exist_passport) == 1);
    }

    /**
     * @return array
     */
    public static function getPageSizeList() : array
    {
        return [20 => 20, 100 => 100, 500 => 500, 1000 => 1000];
    }
}