<?php
/* @var $this ShopController */
/* @var $model WobShops */

$this->breadcrumbs=array(
	$model->name=>array('view','id'=>$model->id),
	WobModule::t('main', 'Update'),
);

$this->menu=array(
	array('label'=>WobModule::t('main', 'List Shops'), 'url'=>array('index')),
	array('label'=>WobModule::t('main', 'Create Shops'), 'url'=>array('create')),
);
$this->h1 = WobModule::t('main', 'Update Shops {name}', array('{name}'=>$model->id));
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>