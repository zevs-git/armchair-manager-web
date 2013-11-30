<?php
/* @var $this DeviceStatusController */
/* @var $model DeviceStatus */

$this->breadcrumbs=array(
	'Device Statuses'=>array('index'),
	$model->device_id,
);

$this->menu=array(
	array('label'=>'List DeviceStatus', 'url'=>array('index')),
	array('label'=>'Create DeviceStatus', 'url'=>array('create')),
	array('label'=>'Update DeviceStatus', 'url'=>array('update', 'id'=>$model->device_id)),
	array('label'=>'Delete DeviceStatus', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->device_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DeviceStatus', 'url'=>array('admin')),
);
?>

<h1>Стутс устройства [<?php echo $model->name_val; ?>]</h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
        'type'=>'striped bordered condensed',
	'data'=>$model,
	'attributes'=>array(
		'device_id',
		'dt',
		'cashbox_state',
		'cash_in_state',
		'error_number',
		'door_state',
		'alarm_state',
		'mas_state',
		'gsm_state_id',
		'gsm_level',
		//'sim_in',
		'pwr_in_id',
		'pwr_ext_val',
		'update_date',
	),
)); ?>
