<?php $this->h1 = WobModule::t('main', 'Pay / select the payment method'); ?>
<?php foreach ($pairs as $pair) { ?>
	<?php echo CHtml::link($pair->currency_1->code, array('currency', 'hash'=>$order->hash,'id_currency'=>$pair->id_currency_1), array('class'=>'btn btn-xlarge')); ?>
<?php } ?>