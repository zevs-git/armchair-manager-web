<?php
/* @var $this StaffController */
/* @var $model Staff */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'staff-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Обязательные поля отмечены символом <span class="required">*</span>.</p>

	<?php echo $form->errorSummary($model); ?>
        
        <div class="row">
            <?php if (Yii::app()->user->checkAccess('Superadmin')): ?> 
                <?php echo $form->labelEx($model,'departament_id'); ?>
                <?php $list = CHtml::listData(Departament::model()->findAll(), 'id', 'name'); ?>
                <?php echo $form->dropDownList($model, 'departament_id', $list,array('class'=>'span2')); ?>
            <?php else:?>
                <?php echo $form->hiddenField($model,'departament_id',array('class'=>'span4','maxlength'=>20,'value'=>Yii::app()->getModule('user')->user()->departament_id)); ?>
            <?php endif;?>
            <?php echo $form->error($model,'departament_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'FIO'); ?>
		<?php echo $form->textField($model,'FIO',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'FIO'); ?>
	</div>

	<div class="row">
            <?php echo $form->labelEx($model,'staff_type_id'); ?>
            <?php $list = array('0'=>'Инкассатор','1'=>'Техник'); ?>
            <?php echo $form->dropDownList($model, 'staff_type_id', $list, array('class' => 'span2')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'key'); ?>
		<?php echo $form->textField($model,'key',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'key'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textField($model,'comment',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить',array('class'=>'btn btn btn-primary')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<img src="/img/personal_key.jpg" />