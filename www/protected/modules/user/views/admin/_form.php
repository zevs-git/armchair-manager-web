<div class="form">

    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'user-form',
        'type' => 'inline',
        'enableAjaxValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

<?php echo $form->errorSummary(array($model, $profile)); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'username', array('class' => 'span2')); ?>
        <?php echo $form->textField($model, 'username', array('size' => 20, 'maxlength' => 20)); ?>
<?php echo $form->error($model, 'username', array('class' => 'alert alert-error')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'password', array('class' => 'span2')); ?>
        <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 128)); ?>
<?php echo $form->error($model, 'password', array('class' => 'alert alert-error')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'email', array('class' => 'span2')); ?>
        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 128)); ?>
<?php echo $form->error($model, 'email', array('class' => 'alert alert-error')); ?>
    </div>

    <div class="row" style="display:none">
        <?php echo $form->labelEx($model, 'superuser', array('class' => 'span2')); ?>
        <?php echo $form->dropDownList($model, 'superuser', User::itemAlias('AdminStatus')); ?>
<?php echo $form->error($model, 'superuser', array('class' => 'alert alert-error')); ?>
    </div>

    <div class="row" <?= (!$model->isNewRecord) ? 'style="display:none"' : '' ?> >
        <div>
            <?php echo $form->labelEx($model, 'role', array('class' => 'span2')); ?>
<?php echo $form->dropDownList($model, 'role', CHtml::listData(User::getRolesList(), 'name', 'descr')); ?>
        </div>
    </div>

    <div class="row" <?= (!$model->isNewRecord) ? 'style="display:none"' : '' ?> >
        <div class="row">
            <?php if (Yii::app()->user->checkAccess('Superadmin')): ?> 
                <?php echo $form->labelEx($model, 'departament_id', array('class' => 'span2',)); ?>
                <?php $list = CHtml::listData(Departament::model()->findAll(), 'id', 'name'); ?>
                <?php echo $form->dropDownList($model, 'departament_id', $list); ?>
            <?php else: ?>
                <?php echo $form->hiddenField($model, 'departament_id', array('class' => 'span4', 'maxlength' => 20, 'value' => Yii::app()->getModule('user')->user()->departament_id)); ?>
            <?php endif; ?>
            <?php echo $form->error($model, 'departament_id'); ?>
        </div>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status', array('class' => 'span2')); ?>
        <?php echo $form->dropDownList($model, 'status', User::itemAlias('UserStatus')); ?>
    <?php echo $form->error($model, 'status', array('class' => 'alert alert-error')); ?>
    </div>
    <?php
    $profileFields = Profile::getFields();
    if ($profileFields) {
        foreach ($profileFields as $field) {
            ?>
            <div class="row">
                <?php echo $form->labelEx($profile, $field->varname, array('class' => 'span2')); ?>
                <?php
                if ($widgetEdit = $field->widgetEdit($profile)) {
                    echo $widgetEdit;
                } elseif ($field->range) {
                    echo $form->dropDownList($profile, $field->varname, Profile::range($field->range));
                } elseif ($field->field_type == "TEXT") {
                    echo CHtml::activeTextArea($profile, $field->varname, array('rows' => 6, 'cols' => 50));
                } else {
                    echo $form->textField($profile, $field->varname, array('size' => 60, 'maxlength' => (($field->field_size) ? $field->field_size : 255)));
                }
                ?>
            <?php echo $form->error($profile, $field->varname, array('class' => 'alert alert-error')); ?>
            </div>
            <?php
        }
    }
    ?>
    <div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('class' => 'btn btn btn-primary')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->