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
    public $thumbnailWidth = 200;

    /**
     * @var string name of directory in @webroot for images
     */
    public $thumbnailHeight = 200;

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
    }
}
