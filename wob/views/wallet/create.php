<?php
/* @var $this ShopController */
/* @var $model WobShops */

$this->breadcrumbs=array(
	'Wallet'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Wallet', 'url'=>array('index')),
);
$this->h1 = 'Create Wallet';
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>