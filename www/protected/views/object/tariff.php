<?php
/* @var $this ObjectController */
/* @var $model Object */

$this->breadcrumbs = array(
    'Объекты' => array('index'),
    $model->id,
);
?>

<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Настройка объекта",
));
?>
<h3>Объект: "<?php echo $model->obj; ?>"</h3>
<?php $this->renderPartial('form_start', array('model' => $model)) ?>

<?php
if (is_null($objectTariff)) {
    $objectTariff = ObjectTariff::model()->findByPk($model->id);
    if (is_null($objectTariff)) {
        $objectTariff = ObjectTariff::model();
    }
}
?>
<div class="form">
    <?php if (is_null($is_save)) { $is_save = (isset($_REQUEST[is_save])) ? $_REQUEST[is_save] : NULL; }?>

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
        'type' => 'horizontal',
        //'htmlOptions' => array('class' => 'well'),
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo $form->errorSummary($objectTariff); ?>
    <?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array('htmlOptions'=>array('style'=>'padding: 20px;')));
    ?>
    <div class="triff_bonus">
        <h3>Базовый тариф</h3>
        <?php echo $form->textField($objectTariff, 'lk1_l', array('class' => 'span1')); ?>
        <span>рублей за</span>
        <?php echo $form->textField($objectTariff, 'lk1_r', array('class' => 'span1')); ?>
        <span>сек</span>
    </div>
    <?php $this->endWidget() ?>
    <style>
        .triff_bonus {
            margin-top: 10px;
        }
        .triff_bonus .hidden {
            display: none;
        }
    </style>
    <?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array('htmlOptions'=>array('style'=>'padding: 20px;')));
    ?>
    <div id="bonus_2" class="triff_bonus">
        <h3>Бонусы</h3>
        <?php echo $form->textField($objectTariff, 'lk2_l', array('class' => 'span1')); ?>
        <span>рублей за</span>
        <?php echo $form->textField($objectTariff, 'lk2_r', array('class' => 'span1')); ?>
        <span>сек</span>
    </div>
    <div id="bonus_3" class="triff_bonus">
        <?php echo $form->textField($objectTariff, 'lk3_l', array('class' => 'span1')); ?>
        <span>рублей за</span>
        <?php echo $form->textField($objectTariff, 'lk3_r', array('class' => 'span1')); ?>
        <span>сек</span>
    </div>
    <div id="bonus_4" class="triff_bonus">
        <?php echo $form->textField($objectTariff, 'lk4_l', array('class' => 'span1')); ?>
        <span>рублей за</span>
        <?php echo $form->textField($objectTariff, 'lk4_r', array('class' => 'span1')); ?>
        <span>сек</span>
    </div>
    <div id="bonus_5" class="triff_bonus">
        <?php echo $form->textField($objectTariff, 'lk5_l', array('class' => 'span1')); ?>
        <span>рублей за</span>
        <?php echo $form->textField($objectTariff, 'lk5_r', array('class' => 'span1')); ?>
        <span>сек</span>
    </div>
    <div id="bonus_6" class="triff_bonus">
        <?php echo $form->textField($objectTariff, 'lk6_l', array('class' => 'span1')); ?>
        <span>рублей за</span>
        <?php echo $form->textField($objectTariff, 'lk6_r', array('class' => 'span1')); ?>
        <span>сек</span>
    </div>
    <div id="bonus_7" class="triff_bonus">
        <?php echo $form->textField($objectTariff, 'lk7_l', array('class' => 'span1')); ?>
        <span>рублей за</span>
        <?php echo $form->textField($objectTariff, 'lk7_r', array('class' => 'span1')); ?>
        <span>сек</span>
    </div>
    <div id="bonus_8" class="triff_bonus">
        <?php echo $form->textField($objectTariff, 'lk8_l', array('class' => 'span1')); ?>
        <span>рублей за</span>
        <?php echo $form->textField($objectTariff, 'lk8_r', array('class' => 'span1')); ?>
        <span>сек</span>
    </div>
    <div id="bonus_9" class="triff_bonus">
        <?php echo $form->textField($objectTariff, 'lk9_l', array('class' => 'span1')); ?>
        <span>рублей за</span>
        <?php echo $form->textField($objectTariff, 'lk9_r', array('class' => 'span1')); ?>
        <span>сек</span>
    </div>
    <div id="bonus_10" class="triff_bonus">
        <?php echo $form->textField($objectTariff, 'lk10_l', array('class' => 'span1')); ?>
        <span>рублей за</span>
        <?php echo $form->textField($objectTariff, 'lk10_r', array('class' => 'span1')); ?>
        <span>сек</span>
    </div>
    <br>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'type' => 'success', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size' => 'small', // null, 'large', 'small' or 'mini'
        'icon' => 'plus',
        'htmlOptions' => array('id' => 'plusBut')
    ));
    ?>
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'type' => 'danger', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size' => 'small', // null, 'large', 'small' or 'mini'
        'icon' => 'minus',
        'htmlOptions' => array('id' => 'minusBut')
    ));
    ?>
    <?php
    $count_bonus = 0;
    for ($i = 3; $i <= 10; $i++) {
        if ($objectTariff->{'lk' . $i . "_l"} || $objectTariff->{'lk' . $i . '_r'}) {
            $count_bonus++;
        }
    }
    ?>
<?php $this->endWidget() ?>

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', array('class' => 'btn btn btn-primary','id'=>'btn-submit')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php $this->endWidget() ?>


    <script>
        for (var i = 10; i ><?= $count_bonus + 2 ?>; i--) {
            $('#bonus_' + i).hide();
            if (i == 3) {
                $('#minusBut').hide();
            }
        }
        
        $('#btn-submit').hide();


        $('#plusBut').click(function() {
            for (var i = 2; i <= 10; i++) {
                if ($('#bonus_' + i).is(':hidden')) {
                    $('#bonus_' + i).show("fast");
                    if (i == 10) {
                        $('#plusBut').hide('fast');
                    }
                    if ($('#minusBut').is(':hidden')) {
                        $('#minusBut').show('fast');
                    }
                    break;
                }
            }
        });

        $('#minusBut').click(function() {
            for (var i = 10; i >= 2; i--) {
                if ($('#bonus_' + i).is(':visible')) {
                    $('#bonus_' + i).hide("fast");
                    $('#ObjectTariff_lk' + i + '_l').val(null);
                    $('#ObjectTariff_lk' + i + '_r').val(null);
                    if ($('#plusBut').is(':hidden')) {
                        $('#plusBut').show('fast');
                    }
                    if (i == 3) {
                        $('#minusBut').hide('fast');
                    }
                    break;
                }
            }
        });
        
        $('.triff_bonus input').change(function() {
           $('#btn-submit').show('fade');
        });
    </script>
