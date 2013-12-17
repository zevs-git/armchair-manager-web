<?php if (Yii::app()->request->isAjaxRequest): ?>
    <div class="modal-header">
        <a id="dlg-close" class="close" data-dismiss="modal">&times;</a>
        <h4><?php echo $model->isNewRecord ? 'Create SettingsTmplDetail' : 'Update SettingsTmplDetail #' . $model->id ?></h4>
    </div>

    <div class="modal-body">
    <?php endif; ?>


    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'settings-tmpl-detail-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->hiddenField($model, 'tmpl_id', array('type' => "hidden")); ?>

    <?php echo $form->labelEx($model, 'var_id'); ?>
    <?php echo $form->error($model, 'var_id'); ?>
    
    <?php $list = CHtml::listData(SettingsVars::model()->findAll(), 'id', 'descr'); ?>
    <?php echo $form->dropDownList($model, 'var_id', $list, array('class' => 'span5', 'empty' => 'Выберите переменную')); ?>
    
    <?php echo $form->labelEx($model, 'acc_lvl'); ?>
    <?php echo $form->error($model, 'acc_lvl'); ?>
    <?php $list = array('0' => 'Администрантор', '1' => 'Суперадминистрантор'); ?>
    <?php echo $form->dropDownList($model, 'acc_lvl', $list, array('class' => 'span5')); ?>

    <?php echo $form->textFieldRow($model, 'default', array('class' => 'span5', 'maxlength' => 100)); ?>

        <?php if (!Yii::app()->request->isAjaxRequest): ?>
        <div class="form-actions">
            <?php
            $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => $model->isNewRecord ? 'Create' : 'Save',
            ));
            ?>
        </div>
<?php endif; ?>
<?php $this->endWidget(); ?>

    <?php if (Yii::app()->request->isAjaxRequest): ?>
    </div>

    <div class="modal-footer">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'type' => 'primary',
            'label' => $model->isNewRecord ? 'Добавить' : 'Сохранить изменения',
            'url' => '#',
            'htmlOptions' => array(
                'id' => 'submit-' . mt_rand(),
                'ajax' => array(
                    'url' => $model->isNewRecord ? $this->createUrl('create') : $this->createUrl('update', array('id' => $model->id)),
                    'type' => 'post',
                    'data' => 'js:$(this).parent().parent().find("form").serialize()',
                    'success' => 'function(r){
					if(r=="success"){
                                                window.location.reload()
					}
					else{
						$("#TBDialogCrud").html(r).modal("show");
					}
				}',
                    'error' => 'function(r) { alert("Данные некорректны!")}',
                ),
            ),
        ));
        ?>
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => 'Отмена',
            'url' => '#',
            'htmlOptions' => array(
                'id' => 'btn-' . mt_rand(),
                'data-dismiss' => 'modal'
            ),
        ));
        ?>
    </div>
<?php endif; ?>