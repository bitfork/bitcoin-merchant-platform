<div class="panel panel-default">
	<div class="panel-heading"><?php echo WobModule::t('main', 'Your data'); ?></div>
	<div class="panel-body">
		<ul class="list-group">
			<li class="list-group-item">
				<?php echo WobModule::t('main', 'Merchant id'); ?>:
				<strong><?php echo $shop->id; ?></strong>
			</li>
			<li class="list-group-item">
				<?php echo WobModule::t('main', 'Email'); ?>:
				<strong><?php echo $shop->email_admin; ?></strong>
			</li>
			<li class="list-group-item">
				<?php echo WobModule::t('main', 'Date of registration'); ?>:
				<strong><?php echo date('d.m.Y', strtotime($shop->create_date)); ?></strong>
			</li>
			<li class="list-group-item">
				<?php echo WobModule::t('main', 'Site'); ?>:
				<strong><?php echo $shop->url; ?></strong>
			</li>
			<li class="list-group-item">
				<?php echo WobModule::t('main', 'Status'); ?>:
				<strong><?php echo ($shop->is_enable==1) ? WobModule::t('main', 'active') : WobModule::t('main', 'not active'); ?></strong>
			</li>
			<li class="list-group-item">
				<?php echo WobModule::t('main', 'Mode'); ?>:
				<strong><?php echo $shop->getStrIsTestMode(); ?></strong>
			</li>
		</ul>
	</div>
</div>