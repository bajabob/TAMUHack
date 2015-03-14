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
  	
	<!-- Preloader -->
	<div class="page-loader">
		<div class="loader">Loading...</div>
	</div>

	<!-- Navigation start -->
	<nav class="navbar navbar-custom navbar-transparent navbar-fixed-top" role="navigation">

		<div class="container">
	
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#custom-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.html">TAMUHACK 2015</a>
			</div>
	
			<div class="collapse navbar-collapse" id="custom-collapse">
	
				<ul class="nav navbar-nav navbar-right">
	
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Home</a>
						<ul class="dropdown-menu">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Multi Page</a>
								<ul class="dropdown-menu">
									<li><a href="mp-index.html">Image Parallax 1</a></li>
									<li><a href="mp-index-2.html">Image Parallax 2</a></li>
									<li><a href="mp-index-3.html">Slider Parallax 1</a></li>
									<li><a href="mp-index-4.html">Slider Parallax 2</a></li>
									<li><a href="mp-index-5.html">Text rotator 1</a></li>
									<li><a href="mp-index-6.html">Text rotator 2</a></li>
									<li><a href="mp-index-7.html">Gradient Overlay 1</a></li>
									<li><a href="mp-index-8.html">Gradient Overlay 2</a></li>
									<li><a href="mp-index-9.html">Video background 1</a></li>
									<li><a href="mp-index-10.html">Video background 2</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">One Page</a>
								<ul class="dropdown-menu">
									<li><a href="index.html">Image Parallax 1</a></li>
									<li><a href="index-2.html">Image Parallax 2</a></li>
									<li><a href="index-3.html">Slider Parallax 1</a></li>
									<li><a href="index-4.html">Slider Parallax 2</a></li>
									<li><a href="index-5.html">Text rotator 1</a></li>
									<li><a href="index-6.html">Text rotator 2</a></li>
									<li><a href="index-7.html">Gradient Overlay 1</a></li>
									<li><a href="index-8.html">Gradient Overlay 2</a></li>
									<li><a href="index-9.html">Video background 1</a></li>
									<li><a href="index-10.html">Video background 2</a></li>
								</ul>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>

	</nav>
	<!-- Navigation end -->


	
	  	<!-- Content -->
	  	<?= $content ?>
	  	<!-- /Content -->
	
		<!-- Divider -->
		<hr class="divider-d">
		<!-- Divider -->
	
		<!-- Footer start -->
		<footer class="footer bg-dark">
			<div class="container">
	
				<div class="row">
	
					<div class="col-sm-6">
						<p class="copyright font-alt">© 2015 <a href="index.html">Rival</a>, All Rights Reserved.</p>
					</div>
	
					<div class="col-sm-6">
						<div class="footer-social-links">
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-dribbble"></i></a>
							<a href="#"><i class="fa fa-skype"></i></a>
						</div>
					</div>
	
				</div><!-- .row -->
	
			</div>
		</footer>
		<!-- Footer end -->
	
	</div>
	<!-- Wrapper end -->
	
	<!-- Scroll-up -->
	<div class="scroll-up">
		<a href="#totop"><i class="fa fa-angle-double-up"></i></a>
	</div>
	
    
  	<?php $this->endBody() ?>
  	</body>
</html>
<?php $this->endPage() ?>
