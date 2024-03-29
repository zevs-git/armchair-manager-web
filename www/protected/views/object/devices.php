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

<div class="form">
    <?php $is_save = (isset($_REQUEST[is_save])) ? $_REQUEST[is_save] : NULL; ?>

        <div id="data-info" class="alert">
            <i class="icon-file"></i>
            <span class="info">Загрузка...</span>
        </div>
    <div class="btn-toolbar">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => 'Добавить устройство',
            'icon' => 'plus-sign',
            'type' => 'primary',
            'buttonType' => 'link',
            'url' => '#',
            'htmlOptions'=>array('id'=>'add-device-btn')
        ));
        ?>
    </div>

    <?php
    $this->widget('bootstrap.widgets.TbGridView', array(
        'id' => 'device-grid',
        'itemsCssClass' => 'table table-striped table-bordered',
        'dataProvider' => $devices->searchByObjectId($model->id),
        'filter' => $devices,
        'columns' => array(
            array('name'=>'id','type'=>'raw','value'=>'CHtml::link(CHtml::encode($data->id),array("device/view","id"=>$data->id))'),
            'IMEI',
            //'soft_version',
            'deviceType.type_name',
            //'object.obj',
            'comment',
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{delete}',
                'buttons' => array(
                    'delete' => array(
                        'url' => 'Yii::app()->createUrl("Object/deleteDevice", array("object_id"=>' . $model->id .',"device_id"=>$data->id))',
                        'click' => 'function(){
                                        if (confirm("Вы действительно хотите удалить устройство из объекта. (Удаленное устройство автоматически попадет на скалад)"))
                                                $("#data-info").removeClass("alert-success");
                                                $("#data-info").removeClass("alert-error");
                                                $("#data-info .info").html("Сохранение данных...");
                                                $("#data-info").show("fast");
                                                var url = $(this).attr("href");
						$.get(url, function(r){
                                                        $.fn.yiiGridView.update("device-grid");
                                                        if (r.length < 15 && r.indexOf("success") >= 0) {
                                                           $("#data-info").addClass("alert-success");
                                                           $("#data-info .info").html("Данные сохраненены");
                                                        } else {
                                                            $("#data-info .info").html("Ошибка сохранентя данных");
                                                            $("#data-info").addClass("alert-error");
                                                        }
						});
						return false;
					}',
                    ),
                   /* 'change' => array(
                        'url' => '',
                        'click'=>'function(){
                                    changeDevice($(this).parent().parent().children(":nth-child(1)").text());
                        }'
                    )*/
                ),
            ),
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
        });
        
        function changeDevice(id) {
            $('#changeModal').modal();
        }
    </script>

</div><!-- form -->
<?php $this->endWidget() ?>
