<?php
/* @var $this ShopController */
/* @var $model WobShops */
/* @var $form CActiveForm */

$this->breadcrumbs=array(
	'Shops'=>array('index'),
	'Create button',
);
$this->h1 = 'Create button';
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'button-form',
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
		'validateOnChange'=>false,
		'beforeValidate'=>'js:formBeforeValidate',
		'afterValidate'=>'js:formAfterValidate',
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<div class="form-group">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'currency_code'); ?>
		<?php echo $form->dropDownList(
			$model,
			'currency_code',
			CHtml::listData(WobCurrency::model()->findAll(), 'code', 'name'),
			array('class'=>'form-control')
		); ?>
		<?php echo $form->error($model,'currency_code'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'currency_code_pay'); ?>
		<?php echo $form->dropDownList(
			$model,
			'currency_code_pay',
			CHtml::listData(WobCurrency::model()->pay()->findAll(), 'code', 'name'),
			array('empty'=>'---', 'class'=>'form-control')
		); ?>
		<?php echo $form->error($model,'currency_code_pay'); ?>
	</div>

	<div class="msg-ok" style="display: none"></div>
	<div class="msg-err myerr" style="display: none"></div>
	<?php echo $form->errorSummary($model, '<b>Warning!</b>', '', array('class'=>'alert alert-danger')); ?>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton('Create', array('class'=>'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<div id="createButton"></div>

<script language="javascript">
function formBeforeValidate(form) {
	$('#createButton').html('...');
	$(form).find('.msg-ok').html('');
	$(form).find('.myerr').html('');
	$(form).find('.msg-ok').hide();
	$(form).find('.myerr').hide();
	return true;
}
function formAfterValidate(form, data, hasError) {
	if(!hasError) {
		if (data.error) {
			$(form).find('.myerr').html(data.error);
			$(form).find('.myerr').show();
		} else {
			$('#createButton').html(data.content);
		}
		return false;
	}
	return true;
}
</script>