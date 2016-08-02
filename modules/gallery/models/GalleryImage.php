<?php

namespace app\modules\gallery\models;

use Yii;
use app\modules\gallery\models\GalleryTag;
use yii\helpers\Html;

/**
 * This is the model class for table "gallery_image".
 *
 * @property integer $id
 * @property string $path
 * @property string $description
 * @property integer $user_id
 * @property string $created_date
 * @property string $updated_date
 *
 * @property GalleryImageTag[] $galleryImageTags
 * @property GalleryRating[] $galleryRatings
 */
class GalleryImage extends \yii\db\ActiveRecord
{
    public function getAuthor()
    {
        $userClass = \app\modules\gallery\Module::getInstance()->userClass;
        return $this->hasOne($userClass, ['id' => 'user_id']);        
    }


    public function getAuthorName() {
        $userName = \app\modules\gallery\Module::getInstance()->userName;
        return $this->author ? $this->author->{$userName} : '';
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'description'], 'required'],
            [['path', 'description'], 'string'],
            [['user_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'description' => 'Description',
            'user_id' => 'User ID',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'author' => 'Author',
        ];
    }

    /**
     * add tags to image
     * 
     * @param string $tags string with tags, separated by GalleryTag::DELIMITER
     * @return void
     */
    public function addTags($tags)
    {
        $this->unlinkAll('tags', true);
        $tags = array_map(
            function ($val) use($tags) {
                return trim($val);
            },
            explode(',', $tags)
        );
        $tags = array_filter($tags);
        if (!empty($tags)) {
            foreach ($tags as $name) {
                $tag = GalleryTag::find()->where(['name' => $name])->one();
                if (!$tag) {
                    $tag = new GalleryTag();
                    $tag->name = $name;
                    $tag->save();
                }
                $this->link('tags', $tag);
            }
        }
    }

    /**
     * return tags of current image model
     * 
     * @return string tags of current image, separated by GalleryTag::DELIMITER
     */
    public function getTagsForWidget()
    {
        return implode(GalleryTag::DELIMITER, array_map(function($item) {
            return trim(Html::encode($item->name));
        }, $this->tags));
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(GalleryTag::className(), ['id' => 'tag_id'])
        ->viaTable('gallery_image_tag', ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGalleryRatings()
    {
        return $this->hasMany(GalleryRating::className(), ['image_id' => 'id']);
    }
}
