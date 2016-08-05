<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\gallery\common\models\GalleryImage */

$this->title = 'Create Gallery Image';
$this->params['breadcrumbs'][] = ['label' => 'Gallery Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-image-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
    ]) ?>

</div>
