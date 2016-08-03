<?php

namespace app\modules\gallery\models;

use Yii;
use app\modules\gallery\models\GalleryImage;

/**
 * This is the model class for table "gallery_tag".
 *
 * @property integer $id
 * @property string $name
 */
class GalleryTag extends \yii\db\ActiveRecord
{
    const DELIMITER = ',';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * get list of all tags in system
     * 
     * @return array [['name' => tagName], ...]
     */
    public static function getAllTags()
    {
        $tags = static::find()
            ->select('name')
            ->asArray()
            ->all();

        return $tags;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(GalleryImage::className(), ['id' => 'image_id'])
        ->viaTable('gallery_image_tag', ['tag_id' => 'id']);
    }

    /**
     * add new tags to the gallery
     * 
     * @param string $tags string with tags, separated by GalleryTag::DELIMITER
     * @return void
     */
    public static function addMultiTags($tags)
    {
        $tags = array_map(
            function ($val) use($tags) {
                return trim($val);
            },
            explode(static::DELIMITER, $tags)
        );
        $tags = array_filter($tags);
        if (!empty($tags)) {
            foreach ($tags as $name) {
                $tag = new GalleryTag();
                $tag->name = $name;
                $tag->save();
            }
        }
    }
}
