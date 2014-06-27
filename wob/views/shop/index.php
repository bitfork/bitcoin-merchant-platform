<?php
/* @var $this ShopController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Shops',
);

$this->menu=array(
	array('label'=>'Create Shops', 'url'=>array('create')),
);
$this->h1 = 'Shops';
?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
