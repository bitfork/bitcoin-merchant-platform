<?php /* @var $this Controller */ ?>
<?php Wob::module()->registerScripts(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

	<div class="navbar navbar-default navbar-static-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="/"><?php echo CHtml::encode(Yii::app()->name); ?></a>
			</div>
			<div class="navbar-collapse collapse">
				<?php $this->widget('wob.components.widgets.WobCourse'); ?>
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>'Кабинет', 'url'=>array('/wob/shop/index')),
						array('label'=>'Login', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest)
					),
					'htmlOptions'=>array('class'=>'nav navbar-nav  navbar-right'),
					'activeCssClass'=>'active',
				)); ?>
			</div><!--/.nav-collapse -->
		</div>
	</div>

	<div class="container">
		<?php if(isset($this->breadcrumbs)):?>
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
				'htmlOptions'=>array('class'=>'breadcrumb'),
			)); ?><!-- breadcrumbs -->
		<?php endif?>
		<?php echo $content; ?>
	</div>

</body>
</html>