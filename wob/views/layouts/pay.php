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
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="navbar-header">
					<a class="navbar-brand" href="/"><?php echo CHtml::encode(Yii::app()->name); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading"><strong><?php echo CHtml::encode($this->h1); ?></strong></div>
				<div class="panel-body">
					<?php echo $content; ?>
				</div>
			</div>
		</div>
	</div>
</div>

</body>
</html>