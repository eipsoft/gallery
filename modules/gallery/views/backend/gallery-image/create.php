<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\gallery\common\models\GalleryImage */

$this->title = Yii::t('gallery', 'Добавить изображение');
$this->params['breadcrumbs'][] = ['label' => Yii::t('gallery', 'Галерея'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
    ]) ?>

</div>
