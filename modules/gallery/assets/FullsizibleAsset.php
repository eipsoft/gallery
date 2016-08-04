<?php
namespace app\modules\gallery\assets;

use yii\web\AssetBundle;

class FullsizibleAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-fullsizable';
    public $css = [
        'css/jquery-fullsizable.css',
        'css/jquery-fullsizable-theme.css',
    ];
    public $js = [
        'js/jquery-fullsizable.min.js',
    ];
}
