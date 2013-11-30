<?php
/* @var $this DeviceStatusController */
/* @var $model DeviceStatus */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'device_id'); ?>
		<?php echo $form->textField($model,'device_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dt'); ?>
		<?php echo $form->textField($model,'dt'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cashbox_state'); ?>
		<?php echo $form->textField($model,'cashbox_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cash_in_state'); ?>
		<?php echo $form->textField($model,'cash_in_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'error_number'); ?>
		<?php echo $form->textField($model,'error_number'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'door_state'); ?>
		<?php echo $form->textField($model,'door_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'alarm_state'); ?>
		<?php echo $form->textField($model,'alarm_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mas_state'); ?>
		<?php echo $form->textField($model,'mas_state'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gsm_state_id'); ?>
		<?php echo $form->textField($model,'gsm_state_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gsm_level'); ?>
		<?php echo $form->textField($model,'gsm_level'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sim_in'); ?>
		<?php echo $form->textField($model,'sim_in'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pwr_in_id'); ?>
		<?php echo $form->textField($model,'pwr_in_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pwr_ext'); ?>
		<?php echo $form->textField($model,'pwr_ext'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'update_date'); ?>
		<?php echo $form->textField($model,'update_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->