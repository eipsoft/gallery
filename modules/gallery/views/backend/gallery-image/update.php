<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\gallery\common\models\GalleryImage */

$this->title = Yii::t('gallery', 'Обновить изображение') . ' #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gallery', 'Админка'), 'url' => ['/admin/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('gallery', 'Галерея'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('gallery', 'Обновление');
?>
<div class="gallery-image-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'tags' => $tags,
    ]) ?>

</div>
