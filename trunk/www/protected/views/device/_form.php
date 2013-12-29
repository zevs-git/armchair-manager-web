<?php if (Yii::app()->request->isAjaxRequest): ?>
<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h4><?php echo $model->isNewRecord ? 'Создать устройство' : 'Редактирвоать устройство #'.$model->id ?></h4>
</div>

<div class="modal-body">
<?php endif; ?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'device-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'IMEI',array('class'=>'span5','maxlength'=>20)); ?>
        
        <?php echo $form->labelEx($model, 'type_id'); ?>
        <?php echo $form->error($model, 'type_id'); ?>
        
	<?php $list = array('0'=>'Тип устройтва 1'); ?>
        <?php echo $form->dropDownList($model, 'type_id', $list, array('class' => 'span5')); ?>

	<?php echo $form->textFieldRow($model,'soft_version',array('class'=>'span5')); ?>

        <?php echo $form->labelEx($model, 'object_id'); ?>
        <?php echo $form->error($model, 'object_id'); ?>
        
	<?php $list = CHtml::listData(Object::model()->findAll(), 'id', 'city'); ?>
        <?php echo $form->dropDownList($model, 'object_id', $list, array('class' => 'span5', 'empty' => 'Выберите объект')); ?>
        
        <?php if ($model->isNewRecord) {
            echo $form->labelEx($model, 'settings_tmpl_id');
            $list = CHtml::listData(SettingsTemplate::model()->findAll(), 'id', 'descr');
            echo  $form->dropDownList($model, 'settings_tmpl_id', $list, array('class' => 'span5'));            
        }
        ?>
	<?php if (!Yii::app()->request->isAjaxRequest): ?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
	<?php endif; ?>
<?php $this->endWidget(); ?>

<?php if (Yii::app()->request->isAjaxRequest): ?>
</div>

<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>$model->isNewRecord ? 'Создать' : 'Сохранить изменения',
        'url'=>'#',
		'htmlOptions'=>array(
			'id'=>'submit-'.mt_rand(),
			'ajax' => array(
				'url'=>$model->isNewRecord ? $this->createUrl('create') : $this->createUrl('update', array('id'=>$model->id)),
				'type'=>'post',
				'data'=>'js:$(this).parent().parent().find("form").serialize()',
				'success'=>'function(r){
					if(r.indexOf("success") >= 0){
						 $.fn.yiiGridView.update("device-grid");
                                                 $("#TBDialogCrud").modal("hide");
					}
					else{
						$("#TBDialogCrud").html(r).modal("show");
					}
				}', 
			),
		),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Закрыть',
        'url'=>'#',
        'htmlOptions'=>array(
			'id'=>'btn-'.mt_rand(),
			'data-dismiss'=>'modal'
		),
    )); ?>
</div>
<?php endif; ?>