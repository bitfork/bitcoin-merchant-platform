<?php
/* @var $this ShopController */
/* @var $data WobShops */
?>

<div class="view">

	<?php echo CHtml::link(CHtml::encode($data->name), array('view', 'id'=>$data->id)); ?>

	<?php echo CHtml::link(WobModule::t('main', 'update'), array('update', 'id'=>$data->id)); ?>
	<?php echo CHtml::link(WobModule::t('main', 'delete'), array('delete', 'id'=>$data->id),array('submit'=>array('delete','id'=>$data->id),'confirm'=>'Are you sure you want to delete this item?')); ?>
	<?php echo CHtml::link(WobModule::t('main', 'orders'), array('/wob/orders/index', 'id'=>$data->id)); ?>
	<?php echo CHtml::link(WobModule::t('main', 'button'), array('button', 'id_shop'=>$data->id)); ?>

</div>