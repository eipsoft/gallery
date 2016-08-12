<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\gallery\common\models\GalleryRatingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('gallery', 'Рейтинги');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-rating-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'authorName',
            [
                'format' => 'raw',
                'value' => function($data){
                    return Html::img($data->image->thumbnail);
                },
                'filter' => false,
            ],
            [
                'class' => 'app\modules\gallery\widgets\backend\grid\RatingColumn',
                'attribute' => 'value',
                'isCanChangeWithAjax' => true,
                'ajaxPath' => Url::toRoute('/admin/gallery/gallery-rating/update'),
                'ajaxKeys' => ['user_id', 'image_id'],
                'filter' => false
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{delete}'
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> ' . Html::encode($this->title) . '</h3>',
            'type'=>'success',
        ],
        'export' => false,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => true,
    ]); ?>
</div>
