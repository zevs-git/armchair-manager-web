<?php
 /* @var $device Device */

$this->breadcrumbs=array(
	'Управление устройствами'=>array('/Device/admin'),
	'Настрйоки устройства',
);

$this->menu=array(
	array('label'=>'Управление устройствами','url'=>array('/Device/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('settings-device-detail-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'TBDialogCrud')); ?>
<?php $this->endWidget(); ?>
<h2>Настройки устройства [<?=$device->IMEI?>]</h2>
<!--<h3>Идентификатор настроек: #<?=$device->settings_id?></h3> -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'settings-device-detail-grid',
	'ajaxUpdate'=>false,
	'dataProvider'=>$model->search_sett($device->id),
	'filter'=>$model,
	'columns'=>array(
		'var_id',
                array('name'=>'var_descr',
                    'value'=>'$data->var->descr'),
		'value',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'buttons' => array(
				'update' => array(
					'click'=>'function(){
						var url = $(this).attr("href");
						$.get(url, function(r){
							$("#TBDialogCrud").html(r).modal("show");
						});
						return false;
					}',
				),
				'view' => array(
					'click'=>'function(){
						var url = $(this).attr("href");
						$.get(url, function(r){
							$("#TBDialogCrud").html(r).modal("show");
						});
						return false;
					}',
				),
			),
		),
	),
));


$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Сохранить',
    'icon'=>'ok',
    'type' => 'success',
    'url' => Yii::app()->createUrl("SettingsDeviceDetail/save/$device->id"),
));

?>
