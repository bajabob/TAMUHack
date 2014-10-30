<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'css/site.css',
    	'css/carousel.css',
    	'css/effects.css'
    ];
    public $js = [
    	'js/docs.min.js',
    	'js/ie10-viewport-bug-workaround.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    	'yii\web\JqueryAsset',
    	'yii\bootstrap\BootstrapAsset',
    	'yii\bootstrap\BootstrapPluginAsset'
    ];
}
