<?php
$this->breadcrumbs=array(
	'Settings Tmpl Details'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SettingsTmplDetail','url'=>array('index')),
	array('label'=>'Create SettingsTmplDetail','url'=>array('create')),
	array('label'=>'View SettingsTmplDetail','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage SettingsTmplDetail','url'=>array('admin')),
);
?>

<h1>Update SettingsTmplDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>