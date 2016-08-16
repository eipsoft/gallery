<?php

namespace app\modules\gallery\rbac;

use yii\rbac\Rule;

/**
 * Check authorID for compliance with user, transmitted via parameters
 */
class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|integer $user the user ID.
     * @param Item $item the role or permission that this rule is associated width.
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return boolean a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (isset($params['image'])) {
            if (isset($params['image']->user_id)) {
                return $params['image']->user_id == $user;
            }
            if ($params['image']['user_id']) {
                return $params['image']['user_id'] == $user;
            }
        }

        return false;
    }
}
