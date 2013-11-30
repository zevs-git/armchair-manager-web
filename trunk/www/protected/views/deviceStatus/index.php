<?php
/* @var $this DeviceStatusController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Device Statuses',
);

$this->menu=array(
	array('label'=>'Create DeviceStatus', 'url'=>array('create')),
	array('label'=>'Manage DeviceStatus', 'url'=>array('admin')),
);
?>

<h1>Device Statuses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
