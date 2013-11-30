<?php
/* @var $this DeviceController */
/* @var $model Device */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'device-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Обязательные поля отмечены символом <span class="required">*</span>.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'IMEI'); ?>
		<?php echo $form->textField($model,'IMEI',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'IMEI'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_id'); ?>
		<?php echo $form->textField($model,'type_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group_id'); ?>
		<?php echo $form->textField($model,'group_id'); ?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'soft_version'); ?>
		<?php echo $form->textField($model,'soft_version'); ?>
		<?php echo $form->error($model,'soft_version'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'SIM'); ?>
		<?php echo $form->textField($model,'SIM',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'SIM'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'object_id'); ?>
		<?php echo $form->textField($model,'object_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'object_id'); ?>
	</div>
        <?php /*
	<div class="row">
		<?php echo $form->labelEx($model,'create_user_id'); ?>
		<?php echo $form->textField($model,'create_user_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'create_user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_date'); ?>
		<?php echo $form->textField($model,'create_date'); ?>
		<?php echo $form->error($model,'create_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_user_id'); ?>
		<?php echo $form->textField($model,'update_user_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'update_user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'update_date'); ?>
		<?php echo $form->textField($model,'update_date'); ?>
		<?php echo $form->error($model,'update_date'); ?>
	</div>
         * 
         */?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Save',array('class'=>'btn btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->