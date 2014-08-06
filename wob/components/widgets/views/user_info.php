<div class="panel panel-default">
	<div class="panel-heading"><?php echo WobModule::t('main', 'Your data'); ?></div>
	<div class="panel-body">
		<ul class="list-group">
			<li class="list-group-item">
				<?php echo WobModule::t('main', 'Email'); ?>:
				<strong><?php echo $user->email; ?></strong>
			</li>
			<li class="list-group-item">
				<?php echo WobModule::t('main', 'Date of registration'); ?>:
				<strong><?php echo date('d.m.Y', strtotime($user->create_at)); ?></strong>
			</li>
			<li class="list-group-item">
				<?php echo WobModule::t('main', 'Status'); ?>:
				<strong><?php echo ($user->status==1) ? WobModule::t('main', 'active') : WobModule::t('main', 'not active'); ?></strong>
			</li>
		</ul>
	</div>
</div>