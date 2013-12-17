<?php
$this->breadcrumbs=array(
	'Settings Templates'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SettingsTemplate','url'=>array('index')),
	array('label'=>'Create SettingsTemplate','url'=>array('create')),
	array('label'=>'View SettingsTemplate','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage SettingsTemplate','url'=>array('admin')),
);
?>

<h1>Update SettingsTemplate <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>