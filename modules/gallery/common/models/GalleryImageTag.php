<?php

namespace app\modules\gallery\common\models;

use Yii;

/**
 * This is the model class for table "gallery_image_tag".
 *
 * @property integer $id
 * @property integer $image_id
 * @property integer $tag_id
 *
 * @property GalleryImage $image
 */
class GalleryImageTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_image_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_id', 'tag_id'], 'integer'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => GalleryImage::className(), 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_id' => Yii::t('gallery', 'Изображение'),
            'tag_id' => Yii::t('gallery', 'Тег'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(GalleryImage::className(), ['id' => 'image_id']);
    }
}
