<?php
/* @var $this ObjectController */
/* @var $model Object */

$this->breadcrumbs=array(
	'Объекты'=>array('index'),
	'Добавить',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Добавить Объект</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>