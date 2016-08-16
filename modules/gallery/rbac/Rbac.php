<?php

namespace app\modules\gallery\rbac;

class Rbac
{
    /**
     * List of permissions
     */
    const PERMISSION_ADD_PHOTO = 'galleryAddPhoto';
    const PERMISSION_EDIT_OWN_PHOTO = 'galleryEditOwnPhoto';
    const PERMISSION_ADMIN_PANEL = 'galleryAdminPanelAccess';
    const PERMISSION_SET_RATING = 'gallerySetRating';

    /**
     * List of permission descriptions
     */

    const DESCRIPTION_ADD_PHOTO = 'Add a photo';
    const DESCRIPTION_EDIT_OWN_PHOTO = 'Edit an own photo';
    const DESCRIPTION_ADMIN_PANEL = 'Access to admin panel';
    const DESCRIPTION_SET_RATING = 'Set a rating to tyhe image';

    /**
     * List of roles
     */
    const ROLE_USER = 'galleryUser';
    const ROLE_ADMIN = 'galleryAdmin';
}
