<?php

namespace app\modules\gallery\assets;

use yii\web\AssetBundle;

class IgAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/gallery/web';
    public $css = [
        'css/bootstrap-select.min.css',
        'css/ig.css',
        'css/main.css',
    ];
    public $js = [
        'js/jquery/jquery.ui.widget.js',
        'js/jquery/jquery.fileupload.js',
        'js/jquery/jquery.iframe-transport.js',
        'js/bootstrap/bootstrap-select.min.js',
        'js/bootstrap/i18n/defaults-ru_RU.js',
        'js/isotope.pkgd.min.js',
        'js/ie.origin.fix.js',
        'js/ig.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
        'yii\web\JqueryAsset',
        'app\modules\gallery\assets\FullsizibleAsset',
    ];
}
