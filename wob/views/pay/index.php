<b><?php echo CHtml::encode($order->getAttributeLabel('id_status')); ?>:</b>
<?php echo CHtml::encode($order->status->name); ?>
<br />

<?php if (!empty($order->id_currency_1)) { ?>
	<b><?php echo CHtml::encode($order->getAttributeLabel('adress')); ?>:</b>
	<?php echo CHtml::encode($order->adress); ?>
	<br />

	<b><?php echo CHtml::encode($order->getAttributeLabel('amount_1')); ?>:</b>
	<?php echo ViewPrice::format($order->amount_1, $order->currency_1->code, $order->currency_1->round); ?>
	<br />

	<b><?php echo CHtml::encode($order->getAttributeLabel('amount_2')); ?>:</b>
	<?php echo ViewPrice::format($order->amount_2, $order->currency_2->code, $order->currency_2->round); ?>
	<br />

	<b><?php echo CHtml::encode($order->getAttributeLabel('course')); ?>:</b>
	<?php echo ViewPrice::format($order->course, $order->currency_2->code, $order->currency_2->round); ?>
	<br />
<?php } else { ?>
	<b>Не выбран способ оплаты</b>
<?php } ?>

<?php echo CHtml::link('Способ оплаты', array('currency', 'hash'=>$order->hash), array('class'=>'btn btn-primary')); ?>