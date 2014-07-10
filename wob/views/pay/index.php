<div class="row">
	<div class="col-md-6">

		<ul class="list-group">
			<li class="list-group-item">
				<b><?php echo CHtml::encode($order->getAttributeLabel('id_status')); ?>:</b>
				<?php echo CHtml::encode($order->status->name); ?>
			</li>
			<?php if (!empty($order->id_currency_1)) { ?>
				<li class="list-group-item">
					<b><?php echo CHtml::encode($order->getAttributeLabel('adress')); ?>:</b>
					<?php echo CHtml::encode($order->adress); ?>
				</li>
				<li class="list-group-item">
					<b><?php echo CHtml::encode($order->getAttributeLabel('note')); ?>:</b>
					<?php echo CHtml::encode($order->note); ?>
				</li>
				<li class="list-group-item">
					<b><?php echo CHtml::encode($order->getAttributeLabel('amount_1')); ?>:</b>
					<?php echo ViewPrice::format($order->amount_1, $order->currency_1->code, $order->currency_1->round); ?>
				</li>
				<li class="list-group-item">
					<b><?php echo CHtml::encode($order->getAttributeLabel('amount_2')); ?>:</b>
					<?php echo ViewPrice::format($order->amount_2, $order->currency_2->code, $order->currency_2->round); ?>
				</li>
				<li class="list-group-item">
					<b><?php echo CHtml::encode($order->getAttributeLabel('course')); ?>:</b>
					<?php echo ViewPrice::format($order->course, $order->currency_2->code, $order->currency_2->round); ?>
				</li>
			<?php } else { ?>
				<li class="list-group-item"><b><?php echo WobModule::t('main', 'Not selected payment method'); ?></b></li>
			<?php } ?>
		</ul>
	</div>
	<div class="col-md-6">
		<?php echo CHtml::link(WobModule::t('main', 'Method of payment'), array('currency', 'hash'=>$order->hash), array('class'=>'btn btn-primary btn-block')); ?>
	</div>
</div>