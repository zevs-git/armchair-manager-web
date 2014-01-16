<?php if (Yii::app()->request->isAjaxRequest): ?>
<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h4><?php echo $model->isNewRecord ? 'Создание нового шаблона настроек' : 'Редактирование шаблона'.$model->id ?></h4>
</div>

<div class="modal-body">
<?php endif; ?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'settings-template-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'descr',array('class'=>'span5','maxlength'=>50)); ?>

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
					if(/^\d+$/.test(r)){
						window.location = "/index.php/settingsTmplDetail/ServiceSettings/"+r;
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