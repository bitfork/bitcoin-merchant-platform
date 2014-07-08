<div class="panel panel-default">
	<div class="panel-heading"><?php echo Yii::t('main', 'Ваши данные'); ?></div>
	<div class="panel-body">
		<ul class="list-group">
			<li class="list-group-item">
				<?php echo Yii::t('main', 'Номер вашего магазина (id_shop)'); ?>:
				<strong><?php echo $shop->id; ?></strong>
			</li>
			<li class="list-group-item">
				Email:
				<strong><?php echo $shop->email_admin; ?></strong>
			</li>
			<li class="list-group-item">
				Дата регистрации:
				<strong><?php echo date('d.m.Y', strtotime($shop->create_date)); ?></strong>
			</li>
			<li class="list-group-item">
				Site:
				<strong><?php echo $shop->url; ?></strong>
			</li>
			<li class="list-group-item">
				Статус:
				<strong><?php echo ($shop->is_enable==1) ? 'активен' : 'не активен'; ?></strong>
			</li>
			<li class="list-group-item">
				Режим:
				<strong><?php echo $shop->getStrIsTestMode(); ?></strong>
			</li>
		</ul>
	</div>
</div>