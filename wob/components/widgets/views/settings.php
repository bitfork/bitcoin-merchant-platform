<div class="panel panel-default">
	<div class="panel-heading"><?php echo Yii::t('main', 'Настройки'); ?></div>
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
			<?php echo Yii::t('main', 'Я хочу, чтобы комиссия добавлялась к стоимости счета (вы больше получаете).'); ?>
		</label>
		<label>
			<?php echo $form->radioButton($model,'is_commission_shop',array('value'=>1,'uncheckValue'=>null)); ?>
			<?php echo Yii::t('main', 'Я хочу, чтобы комиссия вычиталась из получаемых мной денег (выгодно для клиента!).'); ?>
		</label>

		<?php if (Yii::app()->user->hasFlash('wob_settings')) { ?>
		<div class="alert alert-success">
			<?php echo Yii::app()->user->getFlash('wob_settings'); ?>
		</div>
		<?php } ?>

		<?php echo $form->errorSummary($model, '', '', array('class'=>'alert alert-danger')); ?>

		<div class="form-group buttons">
			<?php echo CHtml::submitButton('Save', array('class'=>'btn btn-primary form-control')); ?>
		</div>

		<?php $this->endWidget(); ?>
	</div>
</div>