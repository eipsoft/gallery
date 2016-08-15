<?php

use yii\helpers\Html;
use app\modules\gallery\rbac\Rbac;
//use app\modules\gallery\assets\FullsizibleAsset;
use app\modules\gallery\assets\IgAsset;
use yii\helpers\Json;

//FullsizibleAsset::register($this);
$igAsset = IgAsset::register($this);

$this->title = Yii::t('gallery', 'Компонент \'Галерея\'');
$this->params['breadcrumbs'][] = $this->title;


// if (\Yii::$app->user->can(Rbac::PERMISSION_ADD_PHOTO)) {
//     echo 'Добавить фото';
// }
// echo '<pre>';
// foreach ($images as $image) {
//     if (\Yii::$app->user->can(Rbac::PERMISSION_EDIT_OWN_PHOTO, ['image' => $image])) {
//         echo 'можем изменить';
//     }
//     print_r($image);
// }

// echo '</pre>';

?>

<div class="container-fluid">
    <!--Панель управления галереей-->
    <div class="row ig-control"></div>
    <!--Галерея-->
    <div class="row ig-grid"></div>
</div>

<?php
    $no_img_src = $igAsset->baseUrl . '/images/pi/no-img.png';

    $this->registerJs("
        var data = " . Json::encode($images) . ";
        var CMSCore = {
            'component' : {
                'gallery' : {
                    'no_img_src' : '$no_img_src',
                    'upload'     : {
                        'upload_dir' : 'images/upload',
                        'img_max_sz' : 25 * 1024 * 1024,
                        'mime_types' : ['image/jpeg', 'image/png', 'image/gif']
                    }
                }
            }
        };
    ", \yii\web\View::POS_BEGIN);

    $this->registerJs("
        /**
         * Инициализация галереи.
         */
        var ig = new IG(
            '.ig-grid', '.ig-control', data, 7
        );
    ", \yii\web\View::POS_READY);

?>