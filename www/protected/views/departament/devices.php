<?php
/* @var $this ObjectController */
/* @var $model Object */

$this->breadcrumbs = array(
    'Дилеры' => array('index'),
    $model->id,
);
?>

<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Прамаетры дилера",
));
?>
<h3>Дилер: "<?php echo $model->name; ?>"</h3>
<?php $this->renderPartial('form_start', array('model' => $model)) ?>

<div class="form">
    <?php $is_save = (isset($_REQUEST[is_save])) ? $_REQUEST[is_save] : NULL; ?>

        <div id="data-info" class="alert">
            <i class="icon-file"></i>
            <span class="info">Загрузка...</span>
        </div>
    <div class="btn-toolbar">
        <?php
        /*$this->widget('bootstrap.widgets.TbButton', array(
            'label' => 'Добавить устройство',
            'icon' => 'plus-sign',
            'type' => 'primary',
            'buttonType' => 'link',
            'url' => '#',
            'htmlOptions'=>array('id'=>'add-device-btn')
        ));*/
        ?>
    </div>

    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'device-grid',
        'itemsCssClass' => 'table table-striped table-bordered',
        'dataProvider' => $devices->searchByDepId($model->id),
        //'filter' => $devices,
        'columns' => array(
            'id',
            array('name' => 'object_obj', 'type' => 'html',
            'value' => '$data->object->obj'),
            'IMEI',
            //'soft_version',
            'deviceType.type_name',
            //'object.obj',
            'comment'
        ),
    ));
    ?>


    <!-- Модальное окошко для выбора нужного материала-->      
<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'dataModal')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h4><?= Yii::t("menu", "Выберите из списка устройтв") ?></h4>
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
        $("#data-info").hide();
// Функция для вызова из модального окошка
        function selectData(id) {
            $("#data-info").removeClass('alert-success');
            $("#data-info").removeClass('alert-error');
            $('#dataModal').modal('hide');
            $('#add-device-btn').button('reset');
            $("#data-info .info").html('Сохранение данных...');
            $("#data-info").show('fast');
            /*
            $("#" + field + "_value").html("* " + name);
            $("#data-info").show();
            $('#dataModal').modal("hide");*/
            $.ajax({
                url: "<?php echo $this->createAbsoluteUrl('object/AddDevice/')?>",
                cache: false,
                data: "object_id=" + '<?=$model->id?>'+'&device_id='+id,
                success: function(res) {
                    $.fn.yiiGridView.update('device-grid');
                    if (res.length < 15 && res.indexOf("success") >= 0) {
                        $("#data-info").addClass('alert-success');
                        $("#data-info .info").html('Данные сохраненены');
                    } else {
                        $("#data-info .info").html('Ошибка сохранентя данных');
                        $("#data-info").addClass('alert-error');
                    }
                    $(buttn).button('reset');
                }

            });
            
        }

// Обнуляем data_id если меняем тип данных    
        $('#Menu_type').change(function() {
            //$("#Menu_data_id").val("");
            $("#data-info").hide();
        })

// Функция которая показывает модальное окно с данными для выбора, полученными через AJAX
        $('#add-device-btn').click(function() {
            var buttn = this;
            $(buttn).button('loading');
            $.ajax({
                url: "<?php echo $this->createAbsoluteUrl('object/deviceSelect/' . $model->id) ?>",
                cache: false,
                data: "field=" + event.target.id,
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
    </script>

</div><!-- form -->
<?php $this->endWidget() ?>
