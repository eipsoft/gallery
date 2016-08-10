<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\modules\gallery\assets\FullsizibleAsset;
use app\modules\gallery\assets\AdminAsset;
use app\modules\gallery\widgets\backend\StarRatingAjax;
use himiklab\thumbnail\EasyThumbnailImage;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\gallery\common\models\GalleryImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
FullsizibleAsset::register($this);
AdminAsset::register($this);
$this->title = Yii::t('gallery', 'Галерея');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="gallery-image-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php
    $updateBtn = Html::a('<i class="glyphicon glyphicon-repeat"></i> ' . Yii::t('gallery', 'Обновить'), ['index'], ['class' => 'btn btn-info']);
 ?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'pjaxSettings' => [
            'neverTimeout' => true,
            'options' => [
                'id' => 'gallery-pjax-id',
            ]
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'path',
                'format' => 'raw',
                'value' => function($data){
                    return Html::a(
                        Html::img($data->thumbnail),
                        $data->path,
                        [
                            'class' => 'fullsizable'
                        ]
                    );
                },
                'filter' => false,
            ],
            'description:ntext',
            'authorName',
            [
                //'attribute' => 'path',
                'format' => 'raw',
                'label' => Yii::t('gallery', 'Теги'),
                'value' => function($data){
                    $html = '';
                    $i = 0;
                    foreach ($data->tags as $tag) {
                        $html .= '<span class="label label-success">' . $tag->name . '</span>&nbsp;';
                        if (++$i % 3 == 0) {
                            $html .= '<br /><br />';
                        }
                    }
                    return $html;
                },
                'filter' => false,
            ],
            [
                'attribute' => 'created_date',
                'filter' => false,
                'value' => function($data){
                    return date('Y-m-d H:i:s', $data->created_date);
                }
            ],
            [
                'attribute' => 'average_rating',
                'format' => 'raw',
                'value' => function($data){
                    return StarRatingAjax::widget([
                        'value' => $data->average_rating,
                        'showClear' => false,
                        'readOnly' => true,
                        'disabled' => true
                    ]);
                },
                'filter' => false,
                'contentOptions'=>[ 'style'=>'min-width: 200px'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'white-space: nowrap; text-align: center; letter-spacing: 0.1em; max-width: 7em;'],
                //'template' => '{update}{delete}'
            ],
        ],
        'panel' => [
            'heading' => '<i class="glyphicon glyphicon-globe"></i> ' . Html::encode($this->title),
            'type' => 'success',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('gallery', 'Добавить изображение'), ['create'], ['class' => 'btn btn-success']) . '&nbsp;' . $updateBtn,
            'after' => $updateBtn,
            //'footer' => false
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
<script>
    jQuery(document).ready(function($) {
        initJqueryWidgets();
        //$('#galleryimagesearch-created_date').val('')
        $('#gallery-pjax-id').on('pjax:complete', function(event) {
            initJqueryWidgets();
        });
    });

    function initJqueryWidgets(isOnPjax) {
        $('a.fullsizable').fullsizable({
        });
    }
</script>
