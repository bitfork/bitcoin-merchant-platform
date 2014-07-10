<?php
/* @var $this ShopController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	WobModule::t('main', 'Shops'),
);

$this->menu=array(
	array('label'=>WobModule::t('main', 'Create Shops'), 'url'=>array('create')),
	array('label'=>WobModule::t('main', 'Balance'), 'url'=>array('/wob/wallet/index')),
);
$this->h1 = WobModule::t('main', 'Shops');
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
