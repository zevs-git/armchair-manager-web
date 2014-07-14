<style>
    div.form > form .row {
        margin-bottom: 10px;
    }
</style>

<?php if (Yii::app()->request->isAjaxRequest): ?>
<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h4><?php echo $model->isNewRecord ? 'Создать устройство' : 'Редактирвоать устройство #'.$model->id ?></h4>
</div>

<div class="modal-body">
<img id="loader" style="display: none; width: 100px; height: 100px; position: absolute; left: 50%; margin-left: -50px; top:50%;"
         src='/images/loading.gif' />

<?php endif; ?>

<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'device-form',
        'type' => 'inline',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

<div class="row">
    <?php if (Yii::app()->user->checkAccess('Admin')): ?> 
        <?php echo $form->labelEx($model,'IMEI',array('class'=>'span4')); ?>
	<?php echo $form->textField($model,'IMEI',array('class'=>'span4','maxlength'=>20)); ?>
    <?php else:?>
        <?php echo $form->hiddenField($model,'IMEI',array('class'=>'span4','maxlength'=>20)); ?>
    <?php endif;?>
</div>           
    <div class="row">
        <?php echo $form->labelEx($model, 'type_id',array('class'=>'span4')); ?>
        <?php echo $form->error($model, 'type_id'); ?>
	<?php $list = array('0'=>'Тип устройтва 1','1'=>'Тип устройтва 2'); ?>
        <?php echo $form->dropDownList($model, 'type_id', $list, array('class' => 'span4')); ?>
    </div>
      <?php if ($model->isNewRecord):?>
    <div class="row">
        <?php echo $form->labelEx($model, 'object_id',array('class'=>'span4')); ?>
        <?php echo $form->error($model, 'object_id'); ?>
        
	<?php $list = CHtml::listData(Object::model()->findAll((Yii::app()->user->checkAccess('Superadmin'))?'':'departament_id = ' . Yii::app()->getModule('user')->user()->departament_id ), 'id', 'obj'); ?>
        <?php echo $form->dropDownList($model, 'object_id', $list, array('class' => 'span4')); ?>
    </div>
    <?php endif; ?>
        <?php if ($model->isNewRecord):?>
        <div class="row">
        <?php
            echo $form->labelEx($model, 'settings_tmpl_id',array('class'=>'span4'));
            $list = CHtml::listData(SettingsTemplate::model()->findAll(), 'id', 'descr');
            echo  $form->dropDownList($model, 'settings_tmpl_id', $list, array('class' => 'span4'));  
        ?>
        </div>
        <?php endif; ?>
        <div class="row">
        <?php echo $form->labelEx($model, 'comment',array('class'=>'span4'));?>
        <?php echo $form->textField($model,'comment',array('class'=>'span4','maxlength'=>200)); ?>
        </div>
        <div class="row">
        <?php echo $form->labelEx($model,'ICCID',array('class'=>'span4')); ?>
	<?php echo $form->textField($model,'ICCID',array('class'=>'span4','maxlength'=>20)); ?>
        </div>  
        <div class="row">
        <?php echo $form->labelEx($model,'phone',array('class'=>'span4')); ?>
	<?php echo $form->textField($model,'phone',array('class'=>'span4','maxlength'=>20)); ?>
        </div>  
    	<?php if (!Yii::app()->request->isAjaxRequest): ?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
		)); ?>
	</div>
	<?php endif; ?>
<?php $this->endWidget(); ?>
</div>
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
                                'beforeSend'=>'function() {
                                            $("#loader").show();}',
				'success'=>'function(r){
                                        $("#loader").hide();
					if(r.length < 15 && r.indexOf("success") >= 0){
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