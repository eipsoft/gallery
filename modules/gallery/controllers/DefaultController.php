<?php

namespace app\modules\gallery\controllers;

use yii\web\Controller;
use app\modules\gallery\models\Image;

/**
 * Default controller for the `gallery` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        // \Yii::$app->db->createCommand('create table a(x int(11))')
        //    ->execute();
        //print_r(Image::find()->all());
        return $this->render('index');
    }
}
