<?php
/* @var $this ShopController */
/* @var $model WobShops */

$this->breadcrumbs=array(
	'Wallet'=>array('index'),
	'Заявки на вывод',
);

$this->menu=array(
	array('label'=>'List Wallet', 'url'=>array('index')),
	array('label'=>'Create Payoff', 'url'=>array('payoffCreate', 'id'=>$model->id)),
);
$this->h1 = 'Заявки на вывод';
?>
<h2>Заявки на вывод</h2>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'wallets-grid',
	'dataProvider'=>$list,
	'columns'=>array(
		array(
			'name'=>'amount',
			'type'=>'raw',
			'value'=>'ViewPrice::format($data->amount, $data->wallet->currency->code, $data->wallet->currency->round)',
		),
		'status.name'
	),
	'itemsCssClass'=>'table',
)); ?>