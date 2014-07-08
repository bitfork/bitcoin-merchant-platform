<?php
/* @var $this ShopController */
/* @var $model WobUsersWallet */

$this->breadcrumbs=array(
	'Заявки на вывод',
);

$this->menu=array(
	array('label'=>'List Wallet', 'url'=>array('index')),
	array('label'=>'Payoff', 'url'=>array('payoff', 'id'=>$model->id_wallet)),
);
$this->h1 = 'Заявки на вывод';
?>
<h2>Заявка на вывод <?php echo $modelWallet->currency->code; ?></h2>

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
		<strong>Адрес:</strong>
		<?php echo ($modelWallet->address!='') ? CHtml::encode($modelWallet->address) : Yii::t('main', 'не задан'); ?>
		<?php if ($modelWallet->address!='') { ?>
			<?php echo ($modelWallet->is_address_activate==1)? '<span class="label label-success">'. Yii::t('main', 'подтвержден') .'</span>' : '<span class="label label-default">'. Yii::t('main', 'не подтвержден') .'</span>'; ?>
		<?php } ?>
		<a class="btn btn-info btn-xs" href="<?php echo $this->createUrl('/wob/wallet/update', array('id'=>$modelWallet->id)); ?>">
			<span class="glyphicon glyphicon-pencil"></span> <?php echo Yii::t('main', 'Изменить'); ?>
		</a>
	</div>

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
<hr />
<?php echo $this->renderPartial('payoff', array('list'=>WobOrdersPayoff::getListByWallet($modelWallet->id))); ?>