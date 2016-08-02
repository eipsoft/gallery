<?php

namespace app\models;

class User extends \dektrium\user\models\User
{
    /** @inheritdoc */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => \app\modules\gallery\behaviors\GalleryUserBehavior::className(),
            'userName' => 'username',
        ];
        return $behaviors;
    }
}