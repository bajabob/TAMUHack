<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    	'assets/css/simpletextrotator.css',
    	'assets/css/font-awesome.min.css',
    	'assets/css/et-line-font.css',
    	'assets/css/magnific-popup.css',
    	'assets/css/flexslider.css',
    	'assets/css/animate.css',
    	'assets/css/style.css'
    ];
    public $js = [
    	'assets/js/jquery.mb.YTPlayer.min.js',
    	'assets/js/appear.js',
    	'assets/js/jquery.simple-text-rotator.min.js',
    	'assets/js/jqBootstrapValidation.js',
    	'http://maps.google.com/maps/api/js?sensor=true',
    	'assets/js/gmaps.js',
    	'assets/js/isotope.pkgd.min.js',
    	'assets/js/imagesloaded.pkgd.js',
    	'assets/js/jquery.flexslider-min.js',
    	'assets/js/jquery.magnific-popup.min.js',
    	'assets/js/jquery.fitvids.js',
    	'assets/js/smoothscroll.js',
    	'assets/js/wow.min.js',
    	'assets/js/contact.js',
    	'assets/js/custom.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
    	'yii\web\JqueryAsset',
    	'yii\bootstrap\BootstrapAsset',
    	'yii\bootstrap\BootstrapPluginAsset'
    ];
}
