<?php
$this->breadcrumbs=array(
	'Settings Device Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SettingsDeviceDetail','url'=>array('index')),
	array('label'=>'Manage SettingsDeviceDetail','url'=>array('admin')),
);
?>

<h1>Create SettingsDeviceDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>