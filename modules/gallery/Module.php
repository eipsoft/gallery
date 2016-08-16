<?php

namespace app\modules\gallery;

use yii\base\BootstrapInterface;
use app\modules\gallery\rbac\Rbac as GalleryRbac;
use yii\filters\AccessControl;

/**
 * gallery module definition class
 */
class Module extends \yii\base\Module implements BootstrapInterface
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
     * @var boolean
     */
    public $enableFlashMessages = true;

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

    public function bootstrap($app)
    {
        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'app\modules\gallery\commands';
        }
    }

    public function behaviors()
    {
        return [
            'backendAccess' => [
                'class' => 'app\modules\gallery\filters\BackendFilter',
                'permissions' => [GalleryRbac::PERMISSION_ADMIN_PANEL]
            ],
        ];
    }
}
