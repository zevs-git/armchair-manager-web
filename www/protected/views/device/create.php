<?php
$this->breadcrumbs=array(
	'Devices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Device','url'=>array('index')),
	array('label'=>'Manage Device','url'=>array('admin')),
);
?>

<h2>Новое устройство</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>