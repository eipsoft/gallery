<?php

namespace app\modules\gallery;

/**
 * gallery module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\gallery\controllers';

    /**
     * @var string name of username property in User model
     */
    public $userName;

    /**
     * @var string User model class
     */
    public $userClass;

    /**
     * @var string name of directory in @webroot for images
     */
    public $folder = 'gallery_images';

    /**
     * @var integer
     */
    public $thumbnailWidth = 300;

    /**
     * @var string name of directory in @webroot for images
     */
    public $thumbnailHeight = 300;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->modules = [
           'gridview' => [
                'class' => '\kartik\grid\Module',
            ], 
        ];

        \Yii::$app->i18n->translations['gallery'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'forceTranslation' => true,
            'basePath' => '@app/modules/gallery/messages',
            'fileMap' => [
                'gallery' => 'module.php',
            ],
        ];
    }
}
