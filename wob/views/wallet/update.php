<?php
/* @var $this ShopController */
/* @var $model WobShops */

$this->breadcrumbs=array(
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Wallet', 'url'=>array('index')),
	array('label'=>'Create Wallet', 'url'=>array('create')),
);
$this->h1 = 'Update Wallet '. $model->id;
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>