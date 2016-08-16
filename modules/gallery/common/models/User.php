<?php

namespace app\modules\gallery\common\models;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\modules\gallery\Module as GalleryModule;

class User extends \yii\base\Object
{
    /**
     * get list of all users in system
     *
     * @return array [userId] => userName
     */
    public static function getAllUsers()
    {
        $module = GalleryModule::getInstance();
        $userClass = $module->userClass;
        $userName = $module->userName;
        $users = $userClass::find()
            ->select(['id', $userName])
            ->asArray()
            ->all();
        $users = ArrayHelper::map($users, 'id', $userName);

        array_walk($users, function(&$value, &$key) {
            $value = Html::encode($value);
        });

        return $users;
    }
}
