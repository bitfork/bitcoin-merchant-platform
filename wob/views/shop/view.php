<?php
/* @var $this ShopController */
/* @var $model WobShops */

$this->breadcrumbs=array(
	'Shops'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Shops', 'url'=>array('index')),
	array('label'=>'Create Shops', 'url'=>array('create')),
	array('label'=>'Update Shops', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Shops', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
$this->h1 = 'View Shops #'. $model->id;
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'url',
		'name',
		'password_api',
		'url_result_api',
		array(
			'name'=>'id_currency_2',
			'value'=>$model->currency_2->name,
		),
		array(
			'name'=>'id_currency_1',
			'value'=>$model->strCurrencyPay,
		),
		array(
			'name'=>'is_test_mode',
			'value'=>$model->getStrIsTestMode(),
		),
	),
)); ?>

<br />
<h2>Счета</h2>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'wallets-grid',
	'dataProvider'=>new CArrayDataProvider($model->wallets),
	'columns'=>array(
		array(
			'name'=>'volume',
			'type'=>'raw',
			'value'=>'ViewPrice::format($data->volume, $data->currency->code, $data->currency->round)',
		),
	),
	'itemsCssClass'=>'table',
)); ?>