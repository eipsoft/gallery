<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\gallery\assets\FullsizibleAsset;
use app\modules\gallery\assets\TagAsset;
use app\modules\gallery\assets\AdminAsset;
use app\modules\gallery\widgets\backend\StarRatingAjax;
use app\modules\gallery\common\models\GalleryTag;
use yii\helpers\Json;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\gallery\common\models\GalleryImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

FullsizibleAsset::register($this);
AdminAsset::register($this);
TagAsset::register($this);
$this->title = Yii::t('gallery', 'Галерея');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('@app/modules/gallery/common/views/_alert', [
    'module' => Yii::$app->getModule('gallery'),
]) ?>

<div class="gallery-image-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php
    $updateBtn = Html::a('<i class="glyphicon glyphicon-repeat"></i> ' . Yii::t('gallery', 'Обновить'), ['index'], ['class' => 'btn btn-info']);
 ?>
    <div id="gallery-pjax-id">
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
                    'attribute' => 'tags_search',
                    'format' => 'raw',
                    'label' => Yii::t('gallery', 'Теги'),
                    'value' => function($data){
                        $html = '';
                        $i = 0;
                        foreach ($data->tags as $tag) {
                            $html .= Html::a('<span class="label label-success">' . $tag->name . '</span>&nbsp;', ['index', 'GalleryImageSearch[tags_search]' => $tag->name], ['class' => 'tag_link']);
                            if (++$i % 3 == 0) {
                                $html .= '<br /><br />';
                            }
                        }
                        return $html;
                    },
                ],
                [
                    'attribute' => 'created_date',
                    // 'filter' => DatePicker::widget([
                    //     'model' => $searchModel,
                    //     'attribute' => 'date_from',
                    //     'attribute2' => 'date_to',
                    //     'type' => DatePicker::TYPE_RANGE,
                    //     'separator' => '-',
                    //     'pluginOptions' => ['format' => 'yyyy-mm-dd']
                    // ]),
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
                    'buttons' => [
                        'add_rating' => function ($url, $model) {
                            $customurl = Yii::$app->urlManager->createUrl(['/admin/gallery/gallery-rating/create', 'image_id' => $model->id]);
                            return Html::a( '<span class="glyphicon glyphicon-star"></span>', $customurl,
                                ['title' => Yii::t('gallery', 'Добавить оценку пользователя'), 'data-pjax' => '0']);
                        }
                    ],
                    'contentOptions' => ['style' => 'white-space: nowrap; text-align: center; letter-spacing: 0.1em; max-width: 7em;'],
                    'template' => '{view}{update}{add_rating}{delete}'
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
</div>

<script>
    jQuery(document).ready(function($) {
        initJqueryWidgets();
        $('#gallery-pjax-id').on('pjax:complete', function(event) {
            initJqueryWidgets();
        });
    });

    function initJqueryWidgets(isOnPjax) {
        $('a.fullsizable').fullsizable({
        });

        $('input[name="GalleryImageSearch[tags_search]"]').selectize({
            "plugins":["remove_button"],
            "persist":false,
            "delimeter":'<?= GalleryTag::DELIMITER ?>',
            "valueField":"name",
            "labelField":"name",
            "searchField":["name"],
            "options":<?= Json::encode(GalleryTag::getAllTags()) ?>,
        });
    }
</script>
