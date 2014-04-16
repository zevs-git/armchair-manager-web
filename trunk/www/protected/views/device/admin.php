<?php
$this->breadcrumbs = array(
    'Устройства' => array('index'),
    'Управление',
);

$this->menu = array(
    array('label' => 'Список устройств', 'url' => array('index')),
    array('label' => 'Создать устройтво', 'url' => array('create'), 'linkOptions' => array(
            'ajax' => array(
                'url' => $this->createUrl('create'),
                'success' => 'function(r){$("#TBDialogCrud").html(r).modal("show");}',
            ),
        )),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('device-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'TBDialogCrud')); ?>
<?php $this->endWidget(); ?>

<h3>Управление устройствами</h3>
<!-- 
<?php echo CHtml::link('Расширенный поиск', '#', array('class' => 'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php
$this->renderPartial('_search', array(
    'model' => $model,
));
?>
</div>search-form -->

<div class="btn-toolbar">
    <?php
    if (Yii::app()->user->checkAccess('Device.create')) {
        $this->widget('bootstrap.widgets.TbButton', array(
            'label' => 'Новое устройство',
            'icon' => 'plus-sign',
            'type' => 'primary',
            'buttonType' => 'ajaxLink',
            'url' => $this->createUrl('create'),
            'ajaxOptions' => array(
                'url' => $this->createUrl('create'),
                'success' => 'function(r){$("#TBDialogCrud").html(r).modal("show");}',
            ),
        ));
    }
    ?>
</div>

<?php

$buttons_tmpl = (Yii::app()->user->checkAccess('Device.delete'))?'{view}{delete}':'{view}';
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'device-grid',
    'itemsCssClass' => 'table table-striped table-bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array('name'=>'id',
             'htmlOptions' => array('style' => 'width: 10px; text-align: center;'),
        ),
        'IMEI',
        //'deviceType.type_name',
        array('name' => 'object_obj', 'type' => 'html',
            'value' => '$data->object->obj'),
        'comment',
        'soft_version',
        'ICCID',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => $buttons_tmpl,
            'htmlOptions' => array('style' => 'min-width: 70px; text-align: center;'),
            'buttons' => array(
                'view' => array(
                    'label' => 'Настройки устройтва',
                    'icon' => 'icon-pencil',
                    //'url' => 'Yii::app()->createUrl("object/view", array("id"=>$data->id))',
                    'options' => array(
                        'class' => 'btn btn-small',
                    ),
                ),
                'delete' => array(
                    'options' => array(
                        //'url' => 'Yii::app()->createUrl("object/view", array("id"=>$data->id))',
                        'class' => 'btn btn-small delete',
                    ),
                ),
                'settings' => array(
                    'label' => 'Настройки устройтва',
                    'url' => 'Yii::app()->createUrl("SettingsDeviceDetail",array("admin"=>$data->id))',
                    'icon' => 'icon-cog',
                    'click' => 'function(){
						var url = $(this).attr("href");
                                                document.location = url;
						return false;
					}',
                    'options' => array(
                        'class' => 'btn btn-small delete',
                    ),
                ),
            ),
        ),
    ),
));
?>
