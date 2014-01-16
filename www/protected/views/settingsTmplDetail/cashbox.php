<?php
$this->breadcrumbs = array(
    'Шаблоны настроек' => array('/SettingsTemplate/admin'),
    'Купюроприемник',
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
    <?php if (!isset($is_save)) {$is_save = (isset($_REQUEST[is_save])) ? $_REQUEST[is_save] : NULL; }?>

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

    
    <?php echo $form->dropDownListRow($model, 'model_id', $model->models,array('class' => 'text')); ?>
    <?php echo $form->dropDownListRow($model, 'valuta_id',$model->valutes, array('class' => 'text')); ?>
    <?php echo $form->textFieldRow($model, 'volume', array('class' => 'text')); ?>
    <?php echo $form->dropDownListRow($model, 'coeficient',$model->coeficients, array('class' => 'text')); ?>
    
    <?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array('htmlOptions'=>array('style'=>'padding: 20px;'))); ?>
    <h3>Номиналы</h3>
    <?php echo $form->checkBoxRow($model, 'nominal0', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($model, 'nominal1', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($model, 'nominal2', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($model, 'nominal3', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($model, 'nominal4', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($model, 'nominal5', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($model, 'nominal6', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($model, 'nominal7', array('class' => 'checkbox')); ?>
    <?php $this->endWidget(); ?>
    

    <div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', array('class' => 'btn btn btn-primary')); ?>
    </div>


<?php $this->endWidget(); ?>

</div><!-- form -->
<?php $this->endWidget() ?>
