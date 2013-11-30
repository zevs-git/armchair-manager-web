<?php
/* @var $this DeviceController */
/* @var $model Device */

$this->breadcrumbs=array(
	'Устройства'=>array('index'),
	'Добавить',
);

$this->menu=array(
	array('label'=>'Список устройств', 'url'=>array('index')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Добавить устройство</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>