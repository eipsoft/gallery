<?php

namespace app\modules\gallery\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

class RbacController extends Controller
{
    /**
     * Rbac initialization - create groups and permissions
     * @return void
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll(); //should we do this??

        $addPhoto = $auth->createPermission('addPhoto');
        $addPhoto->description = 'Add a photo';
        $auth->add($addPhoto);

        $rule = new \app\modules\gallery\rbac\AuthorRule;
        $auth->add($rule);
        $editOwnPhoto = $auth->createPermission('editOwnPhoto');
        $editOwnPhoto->description = 'Edit an own photo';
        $editOwnPhoto->ruleName = $rule->name;
        $auth->add($editOwnPhoto);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $addPhoto);

        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $editOwnPhoto);
        $auth->addChild($author, $user);

        $adminPanelAccess = $auth->createPermission('adminPanelAccess');
        $adminPanelAccess->description = 'Access to admin panel';
        $auth->add($adminPanelAccess);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $author);
        $auth->addChild($admin, $adminPanelAccess);

        $this->stdout('Done!' . PHP_EOL);
    }
}