<?php
$this->breadcrumbs=array(
	'Settings Device Details'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SettingsDeviceDetail','url'=>array('index')),
	array('label'=>'Create SettingsDeviceDetail','url'=>array('create')),
	array('label'=>'View SettingsDeviceDetail','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage SettingsDeviceDetail','url'=>array('admin')),
);
?>

<h1>Update SettingsDeviceDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>