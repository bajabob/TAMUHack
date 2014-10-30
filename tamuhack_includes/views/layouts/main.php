<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
  <head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A student organization at Texas A&M University that hosts and attends hackathons and other engineering events.">
    <meta name="author" content="Bob Timm, VP TAMUHack, bobtimm@tamu.edu">
    <link rel="icon" href="<?php echo Url::to('favicon.ico'); ?>">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>
    
  	</head>
  	<body>
  	
  	<?php $this->beginBody() ?>
  
  	<!-- Top Navigation Bar -->
  	<?php echo $this->renderFile('@app/views/site/forms/topNav.php', array()); ?>

  	<!-- Content -->
  	<?= $content ?>
  	<!-- /Content -->

    <!-- FOOTER -->
    <footer>
    	<p class="pull-right"><a href="#">Back to top</a></p>
        <p>&copy; 2014 TAMUHack - A student organization of Texas A&M University &middot; 
        	<a href="#">Privacy</a> &middot; <a href="#">Terms</a>
        </p>
    </footer>
    
  	<?php $this->endBody() ?>
  	</body>
</html>
<?php $this->endPage() ?>
