<?php

namespace app\models;

use app\models\base\BaseActiveRecord;
use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string|null $name
 * @property float $hours
 * @property bool $status
 * @property string $created_at
 * @property string|null $updated_at
 */
class Task extends BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at','hours'], 'safe'],
            [['status'], 'boolean'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
