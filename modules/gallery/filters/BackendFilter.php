<?php

namespace app\modules\gallery\filters;

use Yii;
use yii\web\ForbiddenHttpException;

class BackendFilter extends \yii\base\ActionFilter
{
    public $actions;
    public $permissions;
    /**
    * @param \yii\base\Action $action
    */
    public function beforeAction($action)
    {
        $className = get_class($action->controller);
        if (strpos($className, "\\backend\\") === false) {
            return true;
        } else {
            if (Yii::$app->user->isGuest) {
                Yii::$app->user->loginRequired();
                return false;
            }
            foreach ($this->permissions as $permission) {
                if (!Yii::$app->user->can($permission)) {
                    throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
                }
            }
        }

       return true;
    }
}