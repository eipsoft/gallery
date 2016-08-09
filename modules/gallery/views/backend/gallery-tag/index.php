<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\gallery\common\models\GalleryTagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('gallery', 'Теги');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-tag-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php 
    $updateBtn = Html::a('<i class="glyphicon glyphicon-repeat"></i> ' . Yii::t('gallery', 'Обновить'), ['index'], ['class' => 'btn btn-info']);
 ?>

<?= GridView::widget([
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
                'vAlign' => 'middle',
                'header' => Yii::t('gallery', 'Изменить тег'),
                'headerOptions' => ['class' => 'kv-sticky-column'],
                'contentOptions' => ['class' => 'kv-sticky-column'],
                'editableOptions' => ['header' => Yii::t('gallery', 'тег'), 'size' => 'md']

            ],
            //'name:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'contentOptions' => ['style' => 'white-space: nowrap; text-align: center; letter-spacing: 0.1em; max-width: 7em;'],
            ],
        ],
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> ' . Html::encode($this->title) . '</h3>',
            'type' => 'success',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> ' . Yii::t('gallery', 'Добавить тег'), ['create'], ['class' => 'btn btn-success']) . '&nbsp;' . $updateBtn,
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
