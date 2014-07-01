<?php
/* @var $this ShopController */
/* @var $model WobUsersWallet */

$this->breadcrumbs=array(
	'Wallet'=>array('index'),
	'Заявки на вывод',
);

$this->menu=array(
	array('label'=>'List Wallet', 'url'=>array('index')),
	array('label'=>'Payoff', 'url'=>array('payoff', 'id'=>$model->id_wallet)),
);
$this->h1 = 'Заявки на вывод';
?>
<h2>Заявка на вывод</h2>

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
		<?php echo $form->labelEx($model,'amount'); ?>
		<?php echo $form->textField($model,'amount',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'amount'); ?>
	</div>

	<?php echo $form->errorSummary($model, '', '', array('class'=>'alert alert-danger')); ?>

	<div class="form-group buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class'=>'btn btn-primary')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->