<?php
/* @var $this ShopController */
/* @var $model WobShops */

$this->breadcrumbs=array(
	WobModule::t('main', 'Application for withdrawal'),
);

$this->menu=array(
	array('label'=>WobModule::t('main', 'List Wallet'), 'url'=>array('index')),
	array('label'=>WobModule::t('main', 'Create Payoff'), 'url'=>array('payoffCreate', 'id'=>$model->id)),
);
$this->h1 = WobModule::t('main', 'Application for withdrawal');
?>
<h2><?php echo WobModule::t('main', 'Application for withdrawal'); ?></h2>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'payoffs-grid',
	'dataProvider'=>$list,
	'columns'=>array(
		array(
			'name'=>'create_date',
			'type'=>'raw',
			'value'=>'date("d.m.Y H:i", strtotime($data->create_date))',
		),
		array(
			'name'=>'amount',
			'type'=>'raw',
			'value'=>'ViewPrice::format($data->amount, $data->wallet->currency->code, $data->wallet->currency->round)',
		),
		'status.name',
	),
	'itemsCssClass'=>'table',
	'template'=>'{items}{summary}{pager}',
	'summaryCssClass'=>'pull-right',
	'pagerCssClass'=>'pagination-wrapper',
	'pager' => array(
		'firstPageLabel'=>'&laquo;',
		'prevPageLabel'=>'←',
		'nextPageLabel'=>'→',
		'lastPageLabel'=>'&raquo;',
		'maxButtonCount'=>'10',
		'header'=>'',
		'cssFile'=>false,
		'firstPageCssClass'=>'',
		'internalPageCssClass'=>'',
		'lastPageCssClass'=>'',
		'nextPageCssClass'=>'',
		'previousPageCssClass'=>'',
		'selectedPageCssClass'=>'active',
		'hiddenPageCssClass'=>'disabled',
		'htmlOptions'=>array('class'=>'pagination'),
	),
)); ?>