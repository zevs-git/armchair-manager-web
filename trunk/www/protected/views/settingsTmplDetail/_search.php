<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tmpl_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'var_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'acc_lvl',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'default',array('class'=>'span5','maxlength'=>100)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
