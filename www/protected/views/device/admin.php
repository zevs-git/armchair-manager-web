<?php
$this->breadcrumbs=array(
	'Устройcтва'=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Список устройств','url'=>array('index')),
	array('label'=>'Создать устройтво', 'url'=>array('create'), 'linkOptions'=>array(
		'ajax' => array(
			'url'=>$this->createUrl('create'),
			'success'=>'function(r){$("#TBDialogCrud").html(r).modal("show");}', 
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

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'TBDialogCrud')); ?>
<?php $this->endWidget(); ?>

<h2>Управление устройствами</h2>
<!-- 
<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>search-form -->

<div class="btn-toolbar">
    <?php
$this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Новое устройство',
        'icon'=>'plus-sign',
        'type' => 'primary',
        'buttonType' => 'ajaxLink',
        'url' =>$this->createUrl('create'),
        'ajaxOptions' => array(
			'url'=>$this->createUrl('create'),
			'success'=>'function(r){$("#TBDialogCrud").html(r).modal("show");}', 
		),
    ));
    ?>
</div>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'device-grid',
        'itemsCssClass' => 'table table-striped table-bordered',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'IMEI',
                'soft_version',
		//'deviceType.type_name',
                array('name'=>'object_obj', 'type'=>'html', 
                      'value'=>'$data->object->obj'),
                'comment',
                'ICCID',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'{view}{delete}{settings}',
			'buttons' => array(
                                'settings' => array(
                                        'label'=>'Настройки устройтва',
                                        'url'=>'Yii::app()->createUrl("SettingsDeviceDetail",array("admin"=>$data->id))',
                                        'icon'=>'icon-cog',
                                        'click'=>'function(){
						var url = $(this).attr("href");
                                                document.location = url;
						return false;
					}',
				),
			),
		),
	),
)); ?>
