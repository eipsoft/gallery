<?php

namespace app\modules\gallery\widgets\backend;

use Yii;
use kartik\rating\StarRating;
use yii\base\Widget;

/**
 * StarRating widget with additional options
 * for ajax updating
 * 
 * @author Sergey Semenov <redencill@gmail.com>
 */
class StarRatingAjax extends Widget
{
    /**
     * @var double Rating value
     */
    public $value;

    /**
     * @var object|array Rating model or array with ajax data
     */
    public $model;

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
    public $disabled = false;

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

    public function run()
    {
        $widgetOptions = [];
        $widgetOptions['name'] = 'star_rating';
        $widgetOptions['value'] = $this->value;
        $widgetOptions['disabled'] = $this->disabled;
        $widgetOptions['pluginOptions'] = [
            'size' => $this->size,
            'step' => $this->step,
            'showCaption' => $this->showCaption,
            'showClear' => $this->showClear, 
            'readOnly' => $this->readOnly, 
        ];
        if ($this->isCanChangeWithAjax) {
            foreach ($this->ajaxKeys as $ajaxKey) {
                if (isset($this->model->{$ajaxKey})) {
                    $ajaxData[$ajaxKey] = $this->model->{$ajaxKey};
                } elseif (isset($this->model[$ajaxKey])) {
                    $ajaxData[$ajaxKey] = $this->model[$ajaxKey];
                }
            }
            $ajaxData = json_encode($ajaxData);
            $widgetOptions['pluginEvents'] = [
                "rating.change" => "function(event, value) { 
                    var ajaxData = " . $ajaxData . ";
                    ajaxData['value'] = value;
                    $.ajax({
                        url: '" . $this->ajaxPath . "',
                        async: false,
                        type: 'POST',
                        data: ajaxData
                    });
                }",
                "rating.clear" => "function(event, value) { 
                    var ajaxData = " . $ajaxData . ";
                    ajaxData['value'] = 0;
                    $.ajax({
                        url: '" . $this->ajaxPath . "',
                        async: false,
                        type: 'POST',
                        data: ajaxData
                    });
                }",
            ];
        }
        echo StarRating::widget($widgetOptions);
    }
}
