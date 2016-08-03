<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\gallery\models\GalleryRatingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app/modules/gallery/messages', 'Gallery Ratings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-rating-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php 
        // echo StarRating::widget([
        //     'name' => 'rating_1',
        //     'pluginOptions' => [
        //         'size' => 'xs',
        //         'step' => 0.1,
        //         'showCaption' => false
        //     ]
        // ]);
     ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'authorName',
            'image.path',
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
<?php Pjax::end(); ?></div>
