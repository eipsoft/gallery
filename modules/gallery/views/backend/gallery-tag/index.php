<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\gallery\common\models\GalleryTagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gallery Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-tag-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php //Pjax::begin(); ?>    <?= GridView::widget([
        'id' => 'gallery-images-gridview', 
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'name',
                //'pageSummary' => 'Page Total',
                'vAlign'=>'middle',
                'headerOptions'=>['class'=>'kv-sticky-column'],
                'contentOptions'=>['class'=>'kv-sticky-column'],
                'editableOptions'=>['header'=>'Name', 'size'=>'md']

            ],
            //'name:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'contentOptions' => ['style' => 'white-space: nowrap; text-align: center; letter-spacing: 0.1em; max-width: 7em;'],
            ],
        ],
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> ' . Html::encode($this->title) . '</h3>',
            'type'=>'success',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Create Gallery Tag', ['create'], ['class' => 'btn btn-success']),
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
<?php //Pjax::end(); ?></div>
