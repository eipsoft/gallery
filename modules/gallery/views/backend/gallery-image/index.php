<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use himiklab\thumbnail\EasyThumbnailImage;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\gallery\models\GalleryImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gallery Images';
$this->params['breadcrumbs'][] = $this->title;

$thumbnailWidth = $this->context->module->thumbnailWidth;
$thumbnailHeight = $this->context->module->thumbnailHeight;
?>

<div class="gallery-image-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'path',
                'format' => 'raw',
                'value' => function($data) use ($thumbnailWidth, $thumbnailHeight){
                    // return EasyThumbnailImage::thumbnailImg(
                    //     Yii::getAlias('@webroot') . $data->path,
                    //     $thumbnailWidth,
                    //     $thumbnailHeight,
                    //     EasyThumbnailImage::THUMBNAIL_OUTBOUND,
                    //     ['alt' => $data->description]
                    // );
                    // Image::thumbnail(Yii::getAlias('@webroot') . $data->path, 120, 120)
                    //     ->save(Yii::getAlias('@runtime/thumb-test-photo.jpg'), ['quality' => 80]);
                },
                'filter' => false
            ],
            'description:ntext',
            'authorName',
            'created_date',
            // 'updated_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> ' . Html::encode($this->title) . '</h3>',
            'type'=>'success',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Gallery Image', ['create'], ['class' => 'btn btn-success']),
            'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
            //'footer'=>false
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
