<?php
$this->breadcrumbs=array(
	'Settings Templates'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SettingsTemplate','url'=>array('index')),
	array('label'=>'Manage SettingsTemplate','url'=>array('admin')),
);
?>

<h1>Создание нового шабона настроек</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>