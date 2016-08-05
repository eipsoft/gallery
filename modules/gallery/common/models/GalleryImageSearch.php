<?php

namespace app\modules\gallery\common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\gallery\common\models\GalleryImage;

/**
 * GalleryImageSearch represents the model behind the search form about `app\modules\gallery\common\models\GalleryImage`.
 */
class GalleryImageSearch extends GalleryImage
{
    /**
     * @var string username for search
     */
    public $authorName;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['authorName'], 'safe'],
            [['path', 'description', 'created_date', 'updated_date'], 'safe'],
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

        $userClass = \app\modules\gallery\Module::getInstance()->userClass;
        $userName = \app\modules\gallery\Module::getInstance()->userName;
        $tableName = $userClass::tableName();

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'path',
                'description',
                'authorName' => [
                    'asc' => [$tableName . '.' . $userName => SORT_ASC],
                    'desc' => [$tableName . '.' . $userName => SORT_DESC],
                    'label' => 'Author'
                ],
                'created_date',
                //'averageRating'
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
        ]);

        $query->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'description', $this->description]);

        $query->joinWith(['author' => function ($q) use($tableName, $userName) {
            $q->where('LOWER(' . $tableName . '.' . $userName . ') LIKE "%' . strtolower($this->authorName) . '%"');
        }]);

        return $dataProvider;
    }
}
