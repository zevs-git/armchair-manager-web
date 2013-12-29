<?php
$this->breadcrumbs=array(
	'Settings Device Details',
);

$this->menu=array(
	array('label'=>'Create SettingsDeviceDetail','url'=>array('create')),
	array('label'=>'Manage SettingsDeviceDetail','url'=>array('admin')),
);
?>

<h1>Settings Device Details</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
