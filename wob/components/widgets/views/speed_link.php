<div class="panel-heading">
	<div class="btn-group">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			<?php echo WobModule::t('main', 'Quick Links'); ?> <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<li><?php echo CHtml::link(WobModule::t('main', 'Bring to your account'), array('/wob/wallet/index')); ?></li>
			<li><?php echo CHtml::link(WobModule::t('main', 'Button receiving payment'), array('/wob/shop/button', 'id_shop'=>$id_shop)); ?></li>
			<li><?php echo CHtml::link(WobModule::t('main', 'Settings API'), array('/wob/shop/update', 'id'=>$id_shop)); ?></li>
		</ul>
	</div>
</div>