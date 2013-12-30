<?php
//------------ add the CJuiDialog widget -----------------
if (!empty($asDialog)):
//    $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
//        'id'=>'dlg-address-view-'. $model->device_id,
//        'options'=>array(
//            'title'=>'Статус устройтсва ['. $model->name_val . ']',
//            'autoOpen'=>true,
//            'modal'=>false,
//            'width'=>600,
//            'height'=>500,
//            'show'=>array(
//                'effect'=>'fade',
//                'duration'=>500,
//            ),
//        'hide'=>array(
//                'effect'=>'fade',
//                'duration'=>500,
//            ),  
//        ),
// ));
 
else:
//-------- default code starts here ------------------
?>
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
<?php endif; ?>
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
        'type'=>'striped bordered condensed',
	'data'=>$model,
	'attributes'=>array(
            array('name'=>'name_val', 'type'=>'raw','label'=>'Устройство'),
            array('name'=>'gprs_state_icon', 
                'label'=>'Подключение к серверу',
                'type'=>'raw'),
            'dt',
            array('name'=>'power_state_icon', 
                'type'=>'raw'),
            array('name'=>'pwr_ext_val', 
                'label'=>$model->getAttributeLabel("pwr_ext"),
                'type'=>'raw'),
            array('name'=>'gsm_level_icon', 
                'label'=>$model->getAttributeLabel("gsm_level"),
                'type'=>'raw'),
            array('name'=>'cashbox_state_icon', 
                'label'=>$model->getAttributeLabel("cashbox_state"),
                'type'=>'raw'),
            'cash_in_state',
            'error_number',
            array('name'=>'akb_state_icon', 
                'label'=>$model->getAttributeLabel("pwr_in_id"),
                'type'=>'raw'),
            array('name'=>'massage_state_icon', 
                'label'=>$model->getAttributeLabel("mas_state"),
                'type'=>'raw'),
            array('name'=>'door_state_icon', 
                'label'=>$model->getAttributeLabel("door_state"),
                'type'=>'raw'),
            array('name'=>'alarm_state_icon', 
                'label'=>$model->getAttributeLabel("alarm_state"),
                'type'=>'raw'),
            
            
            
            'update_date',
		/*'name_val',
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
		'update_date',*/
	),
)); ?>

<?php 
  //----------------------- close the CJuiDialog widget ------------
  //if (!empty($asDialog)) $this->endWidget();
?>
