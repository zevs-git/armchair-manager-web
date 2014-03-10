<?php
$this->breadcrumbs = array(
    'Шаблоны настроек' => array('/SettingsTemplate/admin'),
    'Сервисные настройки',
);

$this->menu = array(
    array('label' => 'Шаблоны настроек', 'url' => array('/SettingsTemplate/admin')),
);
?>

<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Настройки шаблона",
));
?>
<h3>Шаблон: [<?php echo $tmpl_name; ?>]</h3>
<?php $this->renderPartial('form_start', array('model' => $model)) ?>

<div class="form">

<?php if (isset($is_save)): ?>
        <div id="data-info" class="alert <?php echo ($is_save) ? 'alert-success' : 'alert-error' ?>">
            <i class="icon-file"></i>
            <span class="info">
    <?php echo ($is_save) ? "Данные сохранены" : "Ошибка при сохранении. Проверьте корректность данных." ?>
            </span>
        </div>
<?php endif; ?>


    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'object-form',
        'type' => 'vertical',
        //'htmlOptions' => array('class' => 'well'),
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model, 'IP_monitoring', array('class' => 'text')); ?>
    <?php echo $form->textFieldRow($model, 'port_monitoring', array('class' => 'text')); ?>
    <?php echo $form->textFieldRow($model, 'IP_config', array('class' => 'text')); ?>
    <?php echo $form->textFieldRow($model, 'port_config', array('class' => 'text')); ?>
    <?php echo $form->textFieldRow($model, 'USSD', array('class' => 'text')); ?>

    <div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', array('class' => 'btn btn btn-primary')); ?>
    </div>


<?php $this->endWidget(); ?>

</div><!-- form -->
<?php $this->endWidget() ?>
