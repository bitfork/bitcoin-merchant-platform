выбрать способ оплаты
<?php foreach ($pairs as $pair) { ?>
	<?php echo CHtml::link($pair->currency_1->name, array('currency', 'hash'=>$order->hash,'id_currency'=>$pair->id_currency_1)); ?>
<?php } ?>