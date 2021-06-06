<?php

namespace app\models\shop;

use app\components\menu\MenuBuilder;
use app\components\menu\SimpleTreeMenu;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int|null $pid
 * @property string|null $name
 * @property string|null $slug
 * @property string|null $description
 * @property int|null $status
 * @property int|null $sort
 * @property string $created_at
 * @property string|null $updated_at
 *
 * @property Product[] $products
 */
class Category extends ActiveRecord
{
    /** @var array */
    private $childs;

    /** @var bool */
    private $hasChilds;

    public function getChilds(): array
    {
        $this->fillChilds();
        return $this->childs;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'status', 'sort'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'name' => 'Name',
            'slug' => 'Slug',
            'description' => 'Description',
            'status' => 'Status',
            'sort' => 'Sort',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }

    public static function menu()
    {
        $menuBuilder = new MenuBuilder(new SimpleTreeMenu());
        return $menuBuilder->menu();
    }

    public function hasChilds(): bool
    {
        $this->fillChilds();
        return !empty($this->childs);
    }

    protected function fillChilds(): void
    {
        if (!$this->childs) {
            $this->childs = Category::find()->where(['pid' => $this->id])->all();
        }
    }

}
