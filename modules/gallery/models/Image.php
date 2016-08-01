<?php

namespace app\modules\gallery\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $title
 * @property string $path
 */
class Image extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'path'], 'required'],
            [['title', 'path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'title' => 'Title',
            'path' => 'Path',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
}
