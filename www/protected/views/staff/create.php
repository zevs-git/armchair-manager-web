<?php
/* @var $this StaffController */
/* @var $model Staff */

$this->breadcrumbs=array(
	'Персонал'=>array('index'),
	'Добавить',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h3>Добавление персонала</h3>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>