<?php

namespace app\modules\gallery\models;

use Yii;

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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGalleryImageTags()
    {
        return $this->hasMany(GalleryImageTag::className(), ['image_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGalleryRatings()
    {
        return $this->hasMany(GalleryRating::className(), ['image_id' => 'id']);
    }
}
