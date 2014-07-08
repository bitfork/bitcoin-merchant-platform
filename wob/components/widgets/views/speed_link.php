<div class="panel-heading">
	<div class="btn-group">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
			Быстрые ссылки <span class="caret"></span>
		</button>
		<ul class="dropdown-menu" role="menu">
			<li><?php echo CHtml::link('Вывести на свой счет', array('/wob/wallet/index')); ?></li>
			<li><?php echo CHtml::link('Кнопка приема платежа', array('/wob/shop/button', 'id_shop'=>$id_shop)); ?></li>
			<li><?php echo CHtml::link('Настройки API', array('/wob/shop/update', 'id'=>$id_shop)); ?></li>
		</ul>
	</div>
</div>