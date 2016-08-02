<?php
namespace app\modules\gallery\models;

use yii\helpers\ArrayHelper;

class User extends \yii\base\Object
{
    /**
     * get list of all users in system
     * 
     * @return array [userId] => userName
     */
    public static function getAllUsers()
    {
        $module = \app\modules\gallery\Module::getInstance();
        $userClass = $module->userClass;
        $userName = $module->userName;
        $users = $userClass::find()
            ->select(['id', $userName])
            ->asArray()
            ->all();
        $users = ArrayHelper::map($users, 'id', $userName);
        return $users;
    }
}