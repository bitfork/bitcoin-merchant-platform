<?php
/* @var $this ShopController */
/* @var $model WobShops */
/* @var $form WobUsersWallet */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shops-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'id_currency'); ?>
		<?php echo $form->dropDownList(
			$model,
			'id_currency',
			CHtml::listData(WobUsersWallet::getCurrencyEmpty($model->id_currency), 'id', 'name'),
			array('class'=>'form-control')
		); ?>
		<?php echo $form->error($model,'id_currency'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<?php echo $form->errorSummary($model, '', '', array('class'=>'alert alert-danger')); ?>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->