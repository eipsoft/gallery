<?php

namespace app\modules\gallery\common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\gallery\common\models\GalleryImage;
use app\modules\gallery\Module as GalleryModule;
use app\modules\gallery\traits\ModuleTrait;

/**
 * GalleryImageSearch represents the model behind the search form about `app\modules\gallery\common\models\GalleryImage`.
 */
class GalleryImageSearch extends GalleryImage
{
    use ModuleTrait;
    /**
     * @var string username for search
     */
    public $authorName;
    /**
     * @var date date from for search
     */
    public $date_from;
    /**
     * @var date date to for search
     */
    public $date_to;
    /**
     * @var string tags
     */
    public $tags_search;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['authorName', 'tags_search'], 'safe'],
            [['path', 'description', 'created_date', 'updated_date'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = GalleryImage::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $userClass = $this->module->userClass;
        $userName = $this->module->userName;
        $tableName = $userClass::tableName();

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'description',
                'authorName' => [
                    'asc' => [$tableName . '.' . $userName => SORT_ASC],
                    'desc' => [$tableName . '.' . $userName => SORT_DESC],
                    'label' => Yii::t('gallery', 'Владелец')
                ],
                'created_date',
                'average_rating'
            ],
            'defaultOrder' => ['id' => SORT_DESC],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->tags_search)) {
            $tags = explode(GalleryTag::DELIMITER, $this->tags_search);
            $subquery = GalleryTag::find();
            foreach ($tags as $tag) {
                $subquery->orFilterWhere(['name' => $tag]);
            }
            $tagIds = [];
            $res = $subquery->all();
            foreach ($res as $_res) {
                $tagIds[] = $_res->id;
            }
            $imageIds = [ -1 ];
            if (!empty($tagIds)) {
                $connection = Yii::$app->getDb();
                $command = $connection->createCommand('
                    SELECT image_id FROM gallery_image_tag WHERE tag_id IN (' . implode(',', $tagIds) . ') GROUP BY image_id HAVING COUNT(*) = ' . count($tagIds));
                $result = $command->queryAll();
                foreach ($result as $_res) {
                    $imageIds[] = $_res['image_id'];
                }

               $query->andFilterWhere([GalleryImage::tableName() . '.id' => $imageIds]);
            }
        }

        // grid filtering conditions
        $query->andFilterWhere(['>=', 'created_date', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
        ->andFilterWhere(['<=', 'created_date', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        $query->andFilterWhere(['like', GalleryImage::tableName() . '.path', $this->path])
            ->andFilterWhere(['like', GalleryImage::tableName() . '.description', $this->description])
            ->andFilterWhere(['like', GalleryImage::tableName() . '.id', $this->id]);

        $query->joinWith(['author' => function ($q) use($tableName, $userName) {
            $condition = 'LOWER(' . $tableName . '.' . $userName . ') LIKE "%' . strtolower($this->authorName) . '%"';
            if (empty($this->authorName)) {
                $condition .= 'OR ' . $tableName . '.' . $userName . ' IS NULL';
            }
            $q->where($condition);
        }]);

        return $dataProvider;
    }
}
