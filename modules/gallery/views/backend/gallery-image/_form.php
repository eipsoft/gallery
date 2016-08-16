<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\selectize\SelectizeTextInput;
use app\modules\gallery\assets\TagAsset;
use app\modules\gallery\assets\AdminAsset;
use app\modules\gallery\common\models\GalleryTag;
use kartik\file\FileInput;

TagAsset::register($this);
AdminAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\gallery\common\models\GalleryImage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gallery-image-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data']
    ]); ?>

    <?=
        $form->field($model, 'upload_image')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'allowedExtensions' => ['jpg','gif','png','jpeg'],
                //'showUpload' => false,
                'initialPreview'=>[
                    $model->path ? Html::img($model->path) : null
                ],
                'overwriteInitial'=>true,
                'showUpload' => false,
            ]
        ]);
    ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'user_id')->dropDownList($users, ['prompt' => Yii::t('gallery', 'Без владельца')]) ?>

    <?php
        echo SelectizeTextInput::widget([
            'name' => 'tags',
            'value' => isset($tags) ? Html::encode($tags) : '',
            'clientOptions' => [
                'plugins' => ['remove_button'],
                'persist' => false,
                'delimeter' => GalleryTag::DELIMITER,
                'valueField' => 'name',
                'labelField' => 'name',
                'searchField' => ['name'],
                'options' => GalleryTag::getAllTags(),

            ],
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('gallery', 'Создать') : Yii::t('gallery', 'Обновить'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
