<?php
/* @var $this ShopController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Wallet',
);
$this->menu=array(
	array('label'=>'Create Wallet', 'url'=>array('create')),
);
$this->h1 = 'Wallet';
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'wallets-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name'=>'volume',
			'type'=>'raw',
			'value'=>'ViewPrice::format($data->volume, $data->currency->code, $data->currency->round)',
		),
		'address',
		array(
			'name'=>'is_address_activate',
			'type'=>'raw',
			'value'=>'($data->is_address_activate==1)?"подтвержден":"не подтвержден"',
		),
		array(
			'class'=>'CButtonColumn',
			'htmlOptions'=>array('width'=>'70px'),
			'template'=>'{payoff} {payoffCreate} {update}',
			'buttons'=>array
			(
				'payoff' => array
				(
					'options'=>array('title'=>'заявки'),
					'label'=>'<span class="glyphicon glyphicon-list"></span>',
					'url'=>'Yii::app()->createUrl("/wob/wallet/payoff", array("id"=>$data->id))',
				),
				'payoffCreate' => array
				(
					'options'=>array('title'=>'вывести'),
					'label'=>'<span class="glyphicon glyphicon-share"></span>',
					'url'=>'Yii::app()->createUrl("/wob/wallet/payoffCreate", array("id"=>$data->id))',
				),
				'update' => array
				(
					'options'=>array('title'=>'Редактировать'),
					'label'=>'<span class="glyphicon glyphicon-edit"></span>',
					'imageUrl'=>false
				),
			),
		),
	),
	'itemsCssClass'=>'table',
)); ?>