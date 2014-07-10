<div class="panel panel-default">
	<div class="panel-heading"><?php echo WobModule::t('main', 'Settings'); ?></div>
	<div class="panel-body">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id'=>'commission-shop-form',
			'enableClientValidation'=>true,
			'clientOptions'=>array(
				'validateOnSubmit'=>true,
			),
		)); ?>

		<label>
			<?php echo $form->radioButton($model,'is_commission_shop',array('value'=>0,'uncheckValue'=>null)); ?>
			<?php echo WobModule::t('main', 'I want to commission added to the account value (do you get).'); ?>
		</label>
		<label>
			<?php echo $form->radioButton($model,'is_commission_shop',array('value'=>1,'uncheckValue'=>null)); ?>
			<?php echo WobModule::t('main', 'I want to commission deducted from the money received by me (beneficial for the customer!).'); ?>
		</label>

		<?php if (Yii::app()->user->hasFlash('wob_settings')) { ?>
		<div class="alert alert-success">
			<?php echo WobModule::app()->user->getFlash('wob_settings'); ?>
		</div>
		<?php } ?>

		<?php echo $form->errorSummary($model, '', '', array('class'=>'alert alert-danger')); ?>

		<div class="form-group buttons">
			<?php echo CHtml::submitButton(WobModule::t('main', 'Save'), array('class'=>'btn btn-primary form-control')); ?>
		</div>

		<?php $this->endWidget(); ?>
	</div>
</div>