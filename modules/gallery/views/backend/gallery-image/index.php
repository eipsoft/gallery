<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use app\modules\gallery\assets\FullsizibleAsset;
use app\modules\gallery\assets\AdminAsset;
use himiklab\thumbnail\EasyThumbnailImage;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\gallery\models\GalleryImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
FullsizibleAsset::register($this);
AdminAsset::register($this);
$this->title = 'Gallery Images';
$this->params['breadcrumbs'][] = $this->title;
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
                'label' => 'Tags',
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
            'created_date',

            [
                'class' => 'yii\grid\ActionColumn',
                //'template' => '{update}{delete}'
            ],
        ],
        'panel' => [
            'heading'=>'<i class="glyphicon glyphicon-globe"></i> ' . Html::encode($this->title),
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
<script>
    jQuery(document).ready(function($) {
        $('a.fullsizable').fullsizable({
          detach_id: 'container'
        });
    });
</script>
