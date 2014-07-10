<?php
/* @var $this ShopController */
/* @var $model WobShops */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'button-form',
	'enableAjaxValidation'=>true,
	'action'=>$this->createUrl('/wob/pay/testSuccess'),
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'validateOnChange'=>false,
		'beforeValidate'=>'js:formBeforeValidate',
		'afterValidate'=>'js:formAfterValidate',
	),
)); ?>

	<div class="form-group">
		<?php echo $form->hiddenField($model,'merchant_id'); ?>
		<?php echo $form->error($model,'merchant_id'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->hiddenField($model,'id_order_shop'); ?>
		<?php echo $form->error($model,'id_order_shop'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->hiddenField($model,'amount'); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->hiddenField($model,'currency_code'); ?>
		<?php echo $form->error($model,'currency_code'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->hiddenField($model,'currency_code_pay'); ?>
		<?php echo $form->error($model,'currency_code_pay'); ?>
	</div>

	<div class="msg-ok" style="display: none"></div>
	<div class="msg-err myerr" style="display: none"></div>
	<div class="form-group buttons">
		<?php echo CHtml::submitButton(WobModule::t('main', 'Successful payment'), array('class'=>'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<textarea name="response"></textarea>

<script language="javascript">
	function formBeforeValidate(form) {
		$('textarea[name=response]').html('...');
		$(form).find('.msg-ok').html('');
		$(form).find('.myerr').html('');
		$(form).find('.msg-ok').hide();
		$(form).find('.myerr').hide();
		return true;
	}
	function formAfterValidate(form, data, hasError) {
		$('textarea[name=response]').html('');
		if(!hasError) {
			if (data.error) {
				$(form).find('.myerr').html(data.error);
				$(form).find('.myerr').show();
			} else {
				$('textarea[name=response]').html(data.content);
			}
			return false;
		}
		return true;
	}
</script>