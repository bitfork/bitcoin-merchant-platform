<?php
/* @var $this ShopController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shops',
);

$this->menu=array(
	array('label'=>'Create Shops', 'url'=>array('create')),
	array('label'=>'Balance', 'url'=>array('/wob/wallet/index')),
);
$this->h1 = 'Shops';
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
