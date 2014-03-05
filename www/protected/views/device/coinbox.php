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

    <?php echo $form->errorSummary($coinbox); ?>

    
    <?php echo $form->dropDownListRow($coinbox, 'model_id', $coinbox->models,array('class' => 'text','id'=>'model_id')); ?>
    <?php echo $form->dropDownListRow($coinbox, 'valuta_id',$coinbox->valutes, array('class' => 'text')); ?>
    <?php echo $form->textFieldRow($coinbox, 'volume', array('class' => 'text')); ?>
    <?php echo $form->dropDownListRow($coinbox, 'coeficient',$coinbox->coeficients, array('class' => 'text','id'=>'coeficient')); ?>
    
    <?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array('htmlOptions'=>array('style'=>'padding: 20px;'))); ?>
    <h3>Номиналы</h3>
    <?php echo $form->checkBoxRow($coinbox, 'nominal0', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($coinbox, 'nominal1', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($coinbox, 'nominal2', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($coinbox, 'nominal3', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($coinbox, 'nominal4', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($coinbox, 'nominal5', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($coinbox, 'nominal6', array('class' => 'checkbox')); ?>
    <?php echo $form->checkBoxRow($coinbox, 'nominal7', array('class' => 'checkbox')); ?>
    <?php $this->endWidget(); ?>
    

    <div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', array('class' => 'btn btn btn-primary')); ?>
    </div>
    
     <?php 
    if ($cashbox->model_id == 1) {
        echo "<script>$('#nominal').hide()</script>";
    }
    if ($cashbox->model_id == 2) {
        echo "<script>$('#coeficient').hide()</script>";
    }
    ?>


<?php $this->endWidget(); ?>

</div><!-- form -->
<?php $this->endWidget() ?>

<script>
    $('#model_id').change(function() {
        if($( this ).val() == 1) {
          $('#nominal').hide('fade');  
          $('#coeficient').show('fade');
        } else {
          $('#nominal').show('fade');  
          $('#coeficient').hide('fade');  
        }
    });
</script>
