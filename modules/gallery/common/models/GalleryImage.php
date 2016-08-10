<?php

namespace app\modules\gallery\common\models;

use Yii;
use app\modules\gallery\common\models\GalleryTag;
use app\modules\gallery\libraries\UploadHandler;
use yii\helpers\Html;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "gallery_image".
 *
 * @property integer $id
 * @property string $path
 * @property string $description
 * @property integer $user_id
 * @property string $created_date
 * @property string $updated_date
 * @property double $average_rating
 *
 * @property GalleryImageTag[] $galleryImageTags
 * @property GalleryRating[] $galleryRatings
 */
class GalleryImage extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $upload_image;

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
            [['description'], 'required'],
            [['upload_image'], 'file', 'extensions' => 'png, jpg, gif, jpeg', 'skipOnEmpty' => true],
            [['upload_image'], 'required', 'on' => 'create'],
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
            'path' => Yii::t('gallery', 'Изображение'),
            'description' => Yii::t('gallery', 'Описание'),
            'user_id' => Yii::t('gallery', 'Пользователь'),
            'authorName' => Yii::t('gallery', 'Пользователь'),
            'created_date' => Yii::t('gallery', 'Дата создания'),
            'updated_date' => Yii::t('gallery', 'Дата обновления'),
            'upload_image' => Yii::t('gallery', 'Изображение'),
            'author' => Yii::t('gallery', 'Пользователь'),
            'average_rating' => Yii::t('gallery', 'Рейтинг'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_date', 'updated_date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_date',
                ],
                'value' => function() { return date('U'); },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        $this->deleteImagePhysically();
        return parent::beforeDelete();
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
            explode(GalleryTag::DELIMITER, $tags)
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
     * delete image and all its thumbnails from file system
     *
     * @return void
     */
    public function deleteImagePhysically()
    {
        $webroot = Yii::getAlias('@webroot');
        @unlink($webroot . $this->path);
        $thumbnail = $this->thumbnail;
        if ($thumbnail) {
            unlink($webroot . $thumbnail);
        }
    }

    /**
     *
     * @return string thumbnail of the image or empty string if not exists
     */
    public function getThumbnail()
    {
        $pathToThumbnail = substr_replace($this->path, '/thumbnail/', strrpos($this->path, '/'), 1);
        return file_exists(Yii::getAlias('@webroot') . $pathToThumbnail) ? $pathToThumbnail : '';
    }

    /**
     * Upload image with helping of UploadHandler and set path
     *
     * @return void
     */
    public function uploadImage()
    {
        $galleryFolderName = \app\modules\gallery\Module::getInstance()->folder;
        $thumbnailWidth = \app\modules\gallery\Module::getInstance()->thumbnailWidth;
        $thumbnailHeight = \app\modules\gallery\Module::getInstance()->thumbnailHeight;
        $subFolderName = 'user' . $this->user_id;
        $folderPath = "/{$galleryFolderName}/{$subFolderName}/";

        $uploadDir = Yii::getAlias('@webroot');
        $uploadDir .= $folderPath;
        $uploadUrl = UploadHandler::get_full_url_static() . "{$folderPath}";
        $paramName = 'GalleryImage';
        ob_start();
        $uploadHandler = new UploadHandler([
            'upload_dir' => $uploadDir,
            'upload_url' => $uploadUrl,
            'param_name' => $paramName,
            'image_versions' => [
                '' => [
                    'auto_orient' => true
                ],
                'thumbnail' => [
                    'crop' => true,
                    'max_width' => $thumbnailWidth,
                    'max_height' => $thumbnailHeight
                ]
            ]
        ]);
        $uploadHandlerResponse = ob_get_contents();
        ob_end_clean();
        $uploadHandlerResponse = json_decode($uploadHandlerResponse, true);
        if (isset($uploadHandlerResponse[$paramName])) {
            $im = array_shift($uploadHandlerResponse[$paramName]);
            if (!isset($im['error'])) {
                $imName = $im['name'];
                $this->path = $folderPath . $imName;
            }
        }
    }

    /**
     * calculates average rating from all users
     *
     * @return double
     */
    public function calculateAverageRating() {
        $avRating = 0;
        if (!empty($this->galleryRatings)) {
            foreach ($this->galleryRatings as $rating) {
                $avRating += $rating->value;
            }
            $avRating = round($avRating / count($this->galleryRatings), 2);
        }
        return $avRating;
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
     * return username of user who added image
     *
     * @return string username - creator of the image
     */
    public function getAuthorName() {
        $userName = \app\modules\gallery\Module::getInstance()->userName;
        return $this->author ? $this->author->{$userName} : '';
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        $userClass = \app\modules\gallery\Module::getInstance()->userClass;
        return $this->hasOne($userClass, ['id' => 'user_id']);
    }
}
