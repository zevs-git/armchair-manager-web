<?php
/* @var $this ObjectController */
/* @var $model Object */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'object-form',
        'type' => 'inline',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Обязательные поля отмечены символом <span class="required">*</span>.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'country',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'region',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'region',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'region'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'city',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'street',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'street',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'house',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'house',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'house'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'type',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'obj',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'obj',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'obj'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'face',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'face',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'face'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment',array('class'=>'span2')); ?>
		<?php echo $form->textField($model,'comment',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить',array('class'=>'btn btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->