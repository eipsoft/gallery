<?php

namespace app\modules\gallery\assets;

use yii\web\AssetBundle;

class FullsizibleAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/gallery/web';
    public $css = [
        'css/jquery-fullsizable/jquery-fullsizable.css',
        'css/jquery-fullsizable/jquery-fullsizable-theme.css',
    ];
    public $js = [
        'js/jquery-fullsizable/jquery-fullsizable.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
