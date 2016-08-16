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
        $addPhoto->description = GalleryRbac::DESCRIPTION_ADD_PHOTO;
        $auth->add($addPhoto);

        $setRating = $auth->createPermission(GalleryRbac::PERMISSION_SET_RATING);
        $setRating->description = GalleryRbac::DESCRIPTION_SET_RATING;
        $auth->add($setRating);

        $authorRule = new \app\modules\gallery\rbac\AuthorRule;
        $auth->add($authorRule);

        $authorizedRule = new \app\modules\gallery\rbac\AuthorizedRule;
        $auth->add($authorizedRule);

        $editOwnPhoto = $auth->createPermission(GalleryRbac::PERMISSION_EDIT_OWN_PHOTO);
        $editOwnPhoto->description = GalleryRbac::DESCRIPTION_EDIT_OWN_PHOTO;
        $editOwnPhoto->ruleName = $authorRule->name;
        $auth->add($editOwnPhoto);

        $user = $auth->createRole(GalleryRbac::ROLE_USER);
        $user->ruleName = $authorizedRule->name;
        $auth->add($user);
        $auth->addChild($user, $addPhoto);
        $auth->addChild($user, $setRating);
        $auth->addChild($user, $editOwnPhoto);

        $adminPanelAccess = $auth->createPermission(GalleryRbac::PERMISSION_ADMIN_PANEL);
        $adminPanelAccess->description = GalleryRbac::DESCRIPTION_ADMIN_PANEL;
        $auth->add($adminPanelAccess);

        $admin = $auth->createRole(GalleryRbac::ROLE_ADMIN);
        $auth->add($admin);
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $adminPanelAccess);

        //add admin
        $auth->assign($admin, 2);

        $this->stdout('Done!' . PHP_EOL);
    }
}
