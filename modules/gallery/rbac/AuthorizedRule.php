<?php

namespace app\modules\gallery\rbac;

use yii\rbac\Rule;

/**
 * Check is user authrized
 */
class AuthorizedRule extends Rule
{
    public $name = 'isAuthorized';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        return !\Yii::$app->user->isGuest;
    }
}