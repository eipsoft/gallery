<?php

namespace app\modules\admin;

use app\modules\gallery\rbac\Rbac as GalleryRbac;
use yii\filters\AccessControl;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'rules' => [
    //                 [
    //                     'allow' => true,
    //                     'roles' => [GalleryRbac::PERMISSION_ADMIN_PANEL],
    //                 ],
    //             ],
    //         ],
    //     ];
    // }
}
