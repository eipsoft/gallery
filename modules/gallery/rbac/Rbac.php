<?php

namespace app\modules\gallery\rbac;

class Rbac
{
    /**
     * List of permissions
     */
    const PERMISSION_ADD_PHOTO = 'addPhoto';
    const PERMISSION_EDIT_OWN_PHOTO = 'editOwnPhoto';
    const PERMISSION_ADMIN_PANEL = 'adminPanelAccess';

    /**
     * List of permission descriptions
     */

    const PERMISSION_ADD_PHOTO_DESCRIPTION = 'Add a photo';
    const PERMISSION_EDIT_OWN_PHOTO_DESCRIPTION = 'Edit an own photo';
    const PERMISSION_ADMIN_PANEL_DESCRIPTION = 'Access to admin panel';

    /**
     * List of roles
     */
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    const ROLE_AUTHOR = 'author';
}