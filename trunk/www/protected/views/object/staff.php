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
$objectStaff = ObjectStaff::model()->findByPk($model->id);
if (is_null($objectStaff)) {
    $objectStaff = ObjectStaff::model();
}
?>
<div class="form">
    <?php $is_save = (isset($_REQUEST[is_save]))?$_REQUEST[is_save]:NULL; ?>
    
    <?php if (!is_null($is_save)):?>
    <div id="data-info" class="alert <?php echo ($is_save === 'true')?'alert-success':'alert-error'?>">
        <i class="icon-file"></i>
        <span class="info">
            <?php echo ($is_save === 'true')?"Данные сохранены":"Ошибка при сохранении. Проверьте корректность данных."?>
        </span>
    </div>
    <?php endif;?>
    
    
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'object-form',
        'type' => 'inline',
        //'htmlOptions' => array('class' => 'well'),
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo $form->errorSummary($model); ?>
    <?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$objectStaff,
        'type' => 'condensed bordered striped',
	'attributes'=>array(
            'incasator1_val' => array(
            'type'=>'raw',
            'name'=>'incasator1_val',
            ),
            'incasator2_val' => array(
            'type'=>'raw',
            'name'=>'incasator2_val',
            ),
            'tehnik1_val' => array(
            'type'=>'raw',
            'name'=>'tehnik1_val',
            ),
            'tehnik2_val' => array(
            'type'=>'raw',
            'name'=>'tehnik2_val',
            )
	),
    )); ?>
        
    <?php echo $form->textField($objectStaff,'incasator1',array('class'=>'hide')); ?>
    <?php echo $form->textField($objectStaff,'incasator2',array('class'=>'hide')); ?>
    <?php echo $form->textField($objectStaff,'tehnik1',array('class'=>'hide')); ?>
    <?php echo $form->textField($objectStaff,'tehnik2',array('class'=>'hide')); ?>


    <!-- Модальное окошко для выбора нужного материала-->      
    <?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'dataModal')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h4><?= Yii::t("menu", "Выберите из списка персонала") ?></h4>
    </div>
    <div class="modal-body"></div>
    <div class="modal-footer">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t("menu", "Отмена"),
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        ));
        ?>
    </div>
<?php $this->endWidget(); ?>
    

    <script>
// Функция для вызова из модального окошка
        function selectData(field,id, name) {
            $("#ObjectStaff_"+field).val(id);
            $("#"+field+"_value").html("* "+name);
            $("#data-info .info").html(name);
            $("#data-info").show();
            $('#dataModal').modal("hide");
        }

// Обнуляем data_id если меняем тип данных    
        $('#Menu_type').change(function() {
            //$("#Menu_data_id").val("");
            $("#data-info").hide();
        })

// Функция которая показывает модальное окно с данными для выбора, полученными через AJAX
        $('.select-btn').click(function() {
            var buttn = this;
            $(buttn).button('loading');
            $.ajax({
                url: "<?php echo $this->createAbsoluteUrl('object/GetStaffList') ?>",
                cache: false,
                data: {
                    field : event.target.id,
                    staff_type : $(buttn).attr('staff_type'),
                },  
                success: function(html) {
                    $(".modal-body").html(html);
                    $(buttn).button('reset');
                    $('#dataModal').modal().css({
                        width: 'auto',
                        'margin-left': function() {
                            return -($(this).width() / 2);
                        },
                    });
                }

            });
        })
        
        $('.delete-btn').click(function() {
            var buttn = this;
            $(buttn).button('loading');
            field = event.target.id;
            $("#ObjectStaff_"+field).val(null);
            $("#"+field+"_value").html("* Не задан");
            $(buttn).button('reset');
        })
    </script>



    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Сохранить' : 'Сохранить', array('class' => 'btn btn btn-primary')); ?>
    </div>

    <?php $this->endWidget(); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'TBDialogCrud')); ?>
<?php $this->endWidget(); ?>

</div><!-- form -->
<?php $this->endWidget() ?>
