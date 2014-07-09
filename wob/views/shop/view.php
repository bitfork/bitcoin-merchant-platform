<?php
/* @var $this ShopController */
/* @var $model WobShops */

$this->breadcrumbs=array(
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
<h3>Статистика оплат</h3>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'orders-grid',
	'dataProvider'=>$orderProvider,
	'columns'=>array(
		'id',
		array(
			'name'=>'create_date',
			'type'=>'raw',
			'value'=>'date("d.m.Y H:i", strtotime($data->create_date))',
			'htmlOptions'=>array('style'=>'width:100px;'),
		),
		array(
			'name'=>'note',
			'htmlOptions'=>array('style'=>'width:300px;'),
		),
		array(
			'name'=>'email',
			'htmlOptions'=>array('style'=>'width:200px;'),
		),
		array(
			'name'=>'amount_1',
			'type'=>'raw',
			'value'=>'ViewPrice::format($data->amount_1, $data->currency_1->code, $data->currency_1->round)',
			'htmlOptions'=>array('style'=>'width:100px;'),
		),
		array(
			'name'=>'amount_2',
			'type'=>'raw',
			'value'=>'ViewPrice::format($data->amount_2, $data->currency_2->code, $data->currency_2->round)',
			'htmlOptions'=>array('style'=>'width:100px;'),
		),
		array(
			'name'=>'course',
			'type'=>'raw',
			'value'=>'ViewPrice::format($data->course, $data->currency_2->code, $data->currency_2->round)',
			'htmlOptions'=>array('style'=>'width:100px;'),
		),
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
<?php if ($payoffProvider!==null) { ?>
	<hr />
	<h3>
		Статистика выплат
		<div class="pull-right">
			<select name="id_wallet_payoff_select">
				<?php foreach ($wallets as $wallet) { ?>
				<option <?php echo ($wallet->id==$wallet_select_id) ? 'selected="selected"' : ''; ?> value="<?php echo $wallet->id; ?>">
					<?php echo $wallet->currency->code; ?>
				</option>
				<?php } ?>
			</select>
		</div>
	</h3>
	<?php
	$js = "
		$('select[name=id_wallet_payoff_select]').change(function(){
			var id_wallet = $(this).val();
			$.ajax({
				type: 'post',
				data: 'id_wallet_payoff_select='+id_wallet,
				url: location.href,
				success: function(html){
					location.href = location.href;
				}
			});
		});
	";
	Yii::app()->clientScript->registerScript('wallet_payoff_select',$js);
	?>
	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'payoffs-grid',
		'dataProvider'=>$payoffProvider,
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
<?php } ?>