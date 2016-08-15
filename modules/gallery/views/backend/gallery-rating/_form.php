<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\rating\StarRating;
use app\modules\gallery\assets\AdminAsset;

AdminAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\gallery\common\models\GalleryRating */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gallery-rating-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="gallery-rating-thumbnail-image">
        <?= Html::img($image->thumbnail) ?>
    </div>


    <?= $form->field($model, 'user_id')->dropDownList($users) ?>

    <?= $form->field($model, 'value')->widget(StarRating::classname(), [
        'pluginOptions' => [
            'size' => 'xs',
            'step' => 0.1,
            'showCaption' => false,
            'showClear' => true,
        ]
    ]) ?>

    <?= $form->field($model, 'image_id')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('gallery', 'Добавить') : Yii::t('gallery', 'Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
