<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\widgets;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
\app\assets\AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
	<!DOCTYPE html>
	<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="UTF-8">
		<title><?= Html::encode($this->title) ?></title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<?= Html::csrfMetaTags() ?>
		<?php $this->head() ?>
	</head>
	<body class="skin-black">
	<header class="header">
		<a href="<?= Url::toRoute('/admin') ?>" class="logo">
			Administrator
		</a>
		<nav class="navbar navbar-static-top" role="navigation">
			<!-- Sidebar toggle button-->
			<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			<div class="navbar-right">
				<?php echo Html::a('Logout', ['/site/logout'], ['class'=>'logout'])?>
			</div>
		</nav>
	</header>

	<div class="wrapper row-offcanvas row-offcanvas-left">
		<!-- Left side column. contains the logo and sidebar -->
		<?php echo widgets\AdminMenu::widget() ?>
		<!-- Right side column. Contains the navbar and content of the page -->
		<aside class="right-side">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<ol class="breadcrumb">
					<?= Breadcrumbs::widget([
						'homeLink' => ['label'=>'Home', 'url' => $webRoot = Yii::$app->getUrlManager()->getBaseUrl() . '/admin'],
						'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
					]) ?>
				</ol>
				<h1>
					<?php echo $this->title ?>
				</h1>
			</section>

			<!-- Main content -->
			<section class="content">
				<?php echo $content ?>
			</section><!-- /.content -->
		</aside><!-- /.right-side -->
	</div><!-- ./wrapper -->
	<?php $this->endBody() ?>
	</body>
	</html>
<?php $this->endPage() ?>