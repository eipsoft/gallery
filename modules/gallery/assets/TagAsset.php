<?php

namespace app\modules\gallery\assets;

use yii\web\AssetBundle;

class TagAsset extends AssetBundle
{
    public $sourcePath = '@bower/selectize/dist';
    public $css = [
        'css/selectize.bootstrap3.css',
        'css/selectize.css',
        'css/selectize.default.css',
        'css/selectize.legacy.css',
    ];
    public $depends = [
        'dosamigos\selectize\SelectizeAsset',
    ];
}
