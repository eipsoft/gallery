<?php

namespace app\modules\gallery\traits;

/**
 * Trait ModuleTrait
 * @property-read Module $module
 */
trait ModuleTrait
{
    /**
     * @return Module
     */
    public function getModule()
    {
        return \Yii::$app->getModule('gallery');
    }
}
