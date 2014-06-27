<?php $this->beginContent(Wob::module()->baseLayout); ?>
<div class="row">
	<div class="col-md-9">
		<div class="panel panel-default">
			<div class="panel-heading"><strong><?php echo CHtml::encode($this->h1); ?></strong></div>
			<div class="panel-body">
				<?php echo $content; ?>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">Operations</div>
			<div class="panel-body">
				<?php
				$this->widget('zii.widgets.CMenu', array(
					'items'=>$this->menu,
					'htmlOptions'=>array('class'=>'operations'),
				));
				?>
			</div>
		</div>
	</div>
</div>
<?php $this->endContent(); ?>