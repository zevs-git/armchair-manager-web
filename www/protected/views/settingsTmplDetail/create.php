<?php
$this->breadcrumbs=array(
	'Settings Tmpl Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SettingsTmplDetail','url'=>array('index')),
	array('label'=>'Manage SettingsTmplDetail','url'=>array('admin')),
);
?>

<h1>Create SettingsTmplDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>