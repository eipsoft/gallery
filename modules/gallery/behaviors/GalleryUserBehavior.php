<?php
    
namespace app\modules\gallery\behaviors;

use Yii;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;

/**
 * Behavior for adding needed functions to user model.
 *
 * @author Sergey Semenov <redencill@gmail.com>
 *
 */
class GalleryUserBehavior extends Behavior
{
    /**
     * @var string name of username property in User model
     */
    public $userName;

    /**
     * get list of all users in system
     * 
     * @return array [userId] => userName
     */
    public function getAllUsers()
    {
        $userClass = $this->owner->modelClass;
        $users = $userClass::find()
            ->select(['id', $this->userName])
            ->asArray()
            ->all();
        $users = ArrayHelper::map($users, 'id', $this->userName);
        return $users;
    }

    /**
     * get username by id
     * 
     * @param integer $id user id
     * @return string username
     */
    public function getUsernameById($id)
    {
        $userClass = $this->owner->modelClass;
        $user = $userClass::find()
            ->select([$this->userName])
            ->where(['id' => $id])
            ->asArray()
            ->one();
        if ($user) {
            return $user[$this->userName];
        }
        
        return '';
    }
}