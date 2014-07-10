<?php
/* @var $this ShopController */
/* @var $model WobShops */

$this->breadcrumbs=array(
	WobModule::t('main', 'Create'),
);

$this->menu=array(
	array('label'=>WobModule::t('main', 'List Shops'), 'url'=>array('index')),
);
$this->h1 = WobModule::t('main', 'Create Shops');
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>