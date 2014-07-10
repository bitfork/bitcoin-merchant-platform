<?php
/* @var $this ShopController */
/* @var $model WobShops */

$this->breadcrumbs=array(
	WobModule::t('main', 'Wallet')=>array('index'),
	WobModule::t('main', 'Create'),
);

$this->menu=array(
	array('label'=>WobModule::t('main', 'List Wallet'), 'url'=>array('index')),
);
$this->h1 = WobModule::t('main', 'Create Wallet');
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>