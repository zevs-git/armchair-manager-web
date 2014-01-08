<?php
/* @var $this ObjectController */
/* @var $model Object */

$this->breadcrumbs = array(
    'Устрйоства' => array('index'),
    $model->id,
);
?>

<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Настройка устройства",
));
?>
<h3>Устройство: [<?php echo $model->IMEI; ?>]</h3>
<?php $this->renderPartial('form_start', array('model' => $model)) ?>

<?php
if (is_null($deviceServiceSettings)) {
    $deviceServiceSettings = DeviceServiceSettings::model()->findByPk($model->id);
    if (is_null($deviceServiceSettings)) {
        $deviceServiceSettings = new DeviceServiceSettings();
    }
}
?>
<div class="form">
    <?php if (!isset($is_save)) {$is_save = (isset($_REQUEST[is_save])) ? $_REQUEST[is_save] : NULL; }?>

<?php if (!is_null($is_save)): ?>
        <div id="data-info" class="alert <?php echo ($is_save === 'true') ? 'alert-success' : 'alert-error' ?>">
            <i class="icon-file"></i>
            <span class="info">
    <?php echo ($is_save === 'true') ? "Данные сохранены" : "Ошибка при сохранении. Проверьте корректность данных." ?>
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

    <?php echo $form->errorSummary($deviceServiceSettings); ?>

    <?php echo $form->textFieldRow($deviceServiceSettings, 'IP_monitoring', array('class' => 'text')); ?>
    <?php echo $form->textFieldRow($deviceServiceSettings, 'port_monitoring', array('class' => 'text')); ?>
    <?php echo $form->textFieldRow($deviceServiceSettings, 'IP_config', array('class' => 'text')); ?>
<?php echo $form->textFieldRow($deviceServiceSettings, 'port_config', array('class' => 'text')); ?>

    <div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', array('class' => 'btn btn btn-primary')); ?>
    </div>


<?php $this->endWidget(); ?>

</div><!-- form -->
<?php $this->endWidget() ?>
