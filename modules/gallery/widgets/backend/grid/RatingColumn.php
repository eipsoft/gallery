<?php
namespace app\modules\gallery\widgets\backend\grid;

use yii\grid\DataColumn;
use app\modules\gallery\widgets\backend\StarRatingAjax;
use Yii;

class RatingColumn extends DataColumn
{
    /**
     * @var string
     */
    public $size = 'xs';

    /**
     * @var double
     */
    public $step = 0.1;

    /**
     * @var bool
     */
    public $showCaption = false;

    /**
     * @var bool
     */
    public $showClear = true;

    /**
     * @var bool
     */
    public $readOnly = false;

    /**
     * @var bool
     */
    public $isCanChangeWithAjax = false;

    /**
     * @var string url for jquery url ajax field
     */
    public $ajaxPath = '';

    /**
     * names of model fields, wich'll be sent with ajax
     * For example, with ['id'] data for ajax will be <code>{'id' => <?= $model->id ?>}</code>
     * 
     * @var array names of model fields
     */
    public $ajaxKeys = [];

    protected function renderDataCellContent($model, $key, $index)
    {
        $value = $this->getDataCellValue($model, $key, $index);
        $html = StarRatingAjax::widget([
            'value' => $value,
            'model' => $model,
            'size' => $this->size,
            'showCaption' => $this->showCaption,
            'isCanChangeWithAjax' => $this->isCanChangeWithAjax,
            'ajaxPath' => $this->ajaxPath,
            'ajaxKeys' => $this->ajaxKeys,
            'showClear' => $this->showClear,
            'readOnly' => $this->readOnly,
        ]);
        return $value === null ? $this->grid->emptyCell : $html;
    }
}