<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\gallery\models\GalleryImage */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gallery Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="gallery-image-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'path',
                'value' => call_user_func(function($data){
                    return Html::img($data->thumbnail);
                }, $model),
                'format' => 'html',
            ],
            'description:ntext',
            'authorName',
            [
                //'attribute' => 'path',
                'label' => 'Tags',
                'value' => call_user_func(function($data){
                    $html = '';
                    $i = 0;
                    foreach ($data->tags as $tag) {
                        $html .= '<span class="label label-success">' . $tag->name . '</span>&nbsp;';                        
                    }
                    return $html;
                }, $model),
                'format' => 'html',
            ],
            'created_date',
            'updated_date',
        ],
    ]) ?>

</div>
