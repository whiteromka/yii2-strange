<?php

namespace app\models\base;

use yii\db\ActiveRecord;

class BaseActiveRecord extends ActiveRecord
{
    /** @var string */
    public $saveError;

    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $result = parent::save($runValidation, $attributeNames);
        if (!$result) {
            $errors = $this->firstErrors;
            $firstKey = array_key_first($errors);
            $this->saveError = $errors[$firstKey];
        }
        return $result;
    }
}