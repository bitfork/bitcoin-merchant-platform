<?php
/* @var $this ShopController */
/* @var $model WobShops */
/* @var $form CActiveForm */

$this->breadcrumbs=array(
	WobModule::t('main', 'Shops')=>array('index'),
	WobModule::t('main', 'Create button'),
);
$this->h1 = WobModule::t('main', 'Create button');
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

	<div class="form-group">
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>
	
	<div class="form-group">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textField($model,'note',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'note'); ?>
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
	<?php echo $form->errorSummary($model, '', '', array('class'=>'alert alert-danger')); ?>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton(WobModule::t('main', 'Create'), array('class'=>'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<div id="createButton"></div>
<textarea id="createButtonInput" class="form-control" rows="10"></textarea>

<script language="javascript">
function formBeforeValidate(form) {
	$('#createButton').html('...');
	$('#createButtonInput').html('');
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
			$('#createButtonInput').html(data.content);
		}
		return false;
	}
	return true;
}
</script>