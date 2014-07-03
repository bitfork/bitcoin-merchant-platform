<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'wobPayButton',
	'enableAjaxValidation'=>false,
	'action'=>$this->createAbsoluteUrl('/wob/pay/new')
)); ?>

	<?php echo CHtml::hiddenField('merchant_id',$model->merchant_id); ?>
	<?php echo CHtml::hiddenField('amount',$model->amount); ?>
	<?php echo CHtml::hiddenField('note',$model->note); ?>
	<?php echo CHtml::hiddenField('currency_code',$model->currency_code); ?>
	<?php echo CHtml::hiddenField('currency_code_pay',$model->currency_code_pay); ?>

	<?php echo CHtml::submitButton('Pay', array('class'=>'btn btn-success')); ?>

<?php $this->endWidget(); ?>