<?php
/* @var $this OrdersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	WobModule::t('main', 'Orders'),
);

$this->menu=array(
	array('label'=>WobModule::t('main', 'List Shops'), 'url'=>array('/wob/shop/index')),
);
$this->h1 = WobModule::t('main', 'Orders');
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
