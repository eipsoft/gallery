<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\gallery\common\models\GalleryTag */

$this->title = Yii::t('gallery', 'Обновить тег') . ' #' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('gallery', 'Админка'), 'url' => ['/admin/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('gallery', 'Теги'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('gallery', 'Обновление');
?>
<div class="gallery-tag-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
