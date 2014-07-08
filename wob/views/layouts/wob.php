<?php $this->beginContent(Wob::module()->baseLayout); ?>
<div class="m-b-10">
<?php $this->widget('wob.components.widgets.WobShopsList'); ?>
</div>
<div class="row">
	<div class="col-md-9">
		<div class="panel panel-default">
			<?php $this->widget('wob.components.widgets.WobSpeedLink'); ?>
			<div class="panel-body">
				<?php echo $content; ?>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<?php $this->widget('wob.components.widgets.WobShopInfo'); ?>
		<?php $this->widget('wob.components.widgets.WobFinance'); ?>
		<?php $this->widget('wob.components.widgets.WobSettings'); ?>
	</div>
</div>
<?php $this->endContent(); ?>