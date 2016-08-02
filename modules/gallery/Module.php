<?php

namespace app\modules\gallery;

/**
 * gallery module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\gallery\controllers';

    /**
     * @var string name of username property in User model
     */
    public $userName;

    /**
     * @var string User model class
     */
    public $userClass;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->modules = [
           'gridview' => [
                'class' => '\kartik\grid\Module',
            ], 
        ];
    }
}
