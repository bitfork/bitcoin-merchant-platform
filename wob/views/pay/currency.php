<?php $this->h1 = WobModule::t('main', 'Pay / select the payment method'); ?>
<?php if (count($pairs)>0) { ?>
	<?php foreach ($pairs as $pair) { ?>
		<?php echo CHtml::link($pair->currency_1->code, array('currency', 'hash'=>$order->hash,'id_currency'=>$pair->id_currency_1), array('class'=>'btn btn-xlarge')); ?>
	<?php } ?>
<?php } else { ?>
	<?php echo WobModule::t('main', 'Unfortunately for this order no payment methods.'); ?>
<?php } ?>