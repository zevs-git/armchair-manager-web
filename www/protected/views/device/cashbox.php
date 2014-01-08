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

    <?php echo $form->errorSummary($cashbox); ?>

    
    <?php echo $form->dropDownListRow($cashbox, 'model_id', $cashbox->models,array('class' => 'text')); ?>
    <?php echo $form->dropDownListRow($cashbox, 'valuta_id',$cashbox->valutes, array('class' => 'text')); ?>
    <?php echo $form->textFieldRow($cashbox, 'volume', array('class' => 'text')); ?>
    <?php echo $form->dropDownListRow($cashbox, 'coeficient',$cashbox->coeficients, array('class' => 'text')); ?>
    
    <?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array('htmlOptions'=>array('style'=>'padding: 20px;'))); ?>
    <h3>Номиналы</h3>
    <?php echo $form->checkBoxRow($cashbox, 'nominal0', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($cashbox, 'nominal1', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($cashbox, 'nominal2', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($cashbox, 'nominal3', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($cashbox, 'nominal4', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($cashbox, 'nominal5', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($cashbox, 'nominal6', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($cashbox, 'nominal7', array('class' => 'checkbox')); ?>
    <?php $this->endWidget(); ?>
    

    <div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', array('class' => 'btn btn btn-primary')); ?>
    </div>


<?php $this->endWidget(); ?>

</div><!-- form -->
<?php $this->endWidget() ?>
