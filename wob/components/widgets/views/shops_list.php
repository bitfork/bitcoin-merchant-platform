<ul class="nav nav-tabs">
	<?php foreach ($shops as $shop) { ?>
		<li<?php echo ($id_shop==$shop->id) ? ' class="active"' : ''; ?>>
			<?php echo CHtml::link(CHtml::encode($shop->name), array('/wob/shop/view', 'id'=>$shop->id)); ?>
		</li>
	<?php } ?>
	<li>
		<?php echo CHtml::link('Новый сайт +', array('/wob/shop/create')); ?>
	</li>
</ul>