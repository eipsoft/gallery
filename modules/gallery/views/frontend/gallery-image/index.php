<?php

use yii\helpers\Html;
use app\modules\gallery\rbac\Rbac;
if (\Yii::$app->user->can(Rbac::PERMISSION_ADD_PHOTO)) {
    echo 'Добавить фото';
}
echo '<pre>';
foreach ($images as $image) {
    if (\Yii::$app->user->can(Rbac::PERMISSION_EDIT_OWN_PHOTO, ['image' => $image])) {
        echo 'можем изменить';
    }
    print_r($image);
}

echo '</pre>';