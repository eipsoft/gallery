<?php

namespace app\modules\gallery\models;

use Yii;

/**
 * This is the model class for table "gallery_rating".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $image_id
 * @property integer $value
 *
 * @property GalleryImage $image
 */
class GalleryRating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'image_id'], 'integer'],
            [['value'], 'double'],
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
            'user_id' => 'User ID',
            'image_id' => 'Image ID',
            'value' => 'Value',
        ];
    }

    /**
     * Set or update rating value
     * @param integer $user_id
     * @param integer $image_id
     * @param double $value rating value
     * @return void
     */
    public static function setRating($user_id, $image_id, $value)
    {
        $rating = self::find()
            ->where(['user_id' => $user_id, 'image_id' => $image_id])
            ->one();
        if (!$rating) {
            $rating = new self;
            $rating->user_id = $user_id;
            $rating->image_id = $image_id;
        }
        $rating->value = $value;
        $rating->save();
        print_r($rating->errors);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(GalleryImage::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        $userClass = \app\modules\gallery\Module::getInstance()->userClass;
        return $this->hasOne($userClass, ['id' => 'user_id']);
    }

    /**
     * return username of user who added rating
     * 
     * @return string username - creator of the rating
     */
    public function getAuthorName() {
        $userName = \app\modules\gallery\Module::getInstance()->userName;
        return $this->author ? $this->author->{$userName} : '';
    }
}
