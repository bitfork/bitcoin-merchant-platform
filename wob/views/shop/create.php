<?php
/* @var $this ShopController */
/* @var $model WobShops */

$this->breadcrumbs=array(
	'Shops'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Shops', 'url'=>array('index')),
);
$this->h1 = 'Create Shops';
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>