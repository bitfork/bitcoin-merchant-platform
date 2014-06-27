<?php
/* @var $this ShopController */
/* @var $model WobShops */

$this->breadcrumbs=array(
	'Shops'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Shops', 'url'=>array('index')),
	array('label'=>'Create Shops', 'url'=>array('create')),
);
$this->h1 = 'Update Shops '. $model->id;
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>