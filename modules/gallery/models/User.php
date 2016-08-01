<?php

namespace app\modules\gallery\models;

use Yii;

class User extends \yii\base\Object
{
    /**
     * Return list of all users or empty array
     *
     * @return array as [userId] => userName
     */
    public static function getAllUsers()
    {
        if (!Yii::$app->user->isGuest) {
            $user = Yii::$app->user->identity;
            $users = $user instanceof app\modules\gallery\interfaces\GalleryUserInterface
                ? $user->getAllUsers()
                : array();
        }

        return array();
    }

}
