<?php
/* @var $this ShopController */
/* @var $model WobShops */

$this->breadcrumbs=array(
	$model->id=>array('view','id'=>$model->id),
	WobModule::t('main', 'Update'),
);

$this->menu=array(
	array('label'=>WobModule::t('main', 'List Wallet'), 'url'=>array('index')),
	array('label'=>WobModule::t('main', 'Create Wallet'), 'url'=>array('create')),
);
$this->h1 = WobModule::t('main', 'Update Wallet {id}', array('{id}'=>$model->id));
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>