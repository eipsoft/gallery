<?php

namespace app\modules\gallery\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use app\modules\gallery\rbac\Rbac as GalleryRbac;

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

        $addPhoto = $auth->createPermission(GalleryRbac::PERMISSION_ADD_PHOTO);
        $addPhoto->description = GalleryRbac::PERMISSION_ADD_PHOTO_DESCRIPTION;
        $auth->add($addPhoto);

        $rule = new \app\modules\gallery\rbac\AuthorRule;
        $auth->add($rule);
        $editOwnPhoto = $auth->createPermission(GalleryRbac::PERMISSION_EDIT_OWN_PHOTO);
        $editOwnPhoto->description = GalleryRbac::PERMISSION_EDIT_OWN_PHOTO_DESCRIPTION;
        $editOwnPhoto->ruleName = $rule->name;
        $auth->add($editOwnPhoto);

        $user = $auth->createRole(GalleryRbac::ROLE_USER);
        $auth->add($user);
        $auth->addChild($user, $addPhoto);

        $author = $auth->createRole(GalleryRbac::ROLE_AUTHOR);
        $auth->add($author);
        $auth->addChild($author, $editOwnPhoto);
        $auth->addChild($author, $user);

        $adminPanelAccess = $auth->createPermission(GalleryRbac::PERMISSION_ADMIN_PANEL);
        $adminPanelAccess->description = GalleryRbac::PERMISSION_EDIT_OWN_PHOTO_DESCRIPTION;
        $auth->add($adminPanelAccess);

        $admin = $auth->createRole(GalleryRbac::ROLE_ADMIN);
        $auth->add($admin);
        $auth->addChild($admin, $author);
        $auth->addChild($admin, $adminPanelAccess);

        $this->stdout('Done!' . PHP_EOL);
    }
}