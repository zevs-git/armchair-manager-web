<?php
/* @var $this StaffController */
/* @var $model Staff */

$this->breadcrumbs=array(
	'Персонал'=>array('index'),
	$model->FIO=>array('view','id'=>$model->id),
	'Редактировать',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Просмотреть', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Редактирование [<?php echo $model->FIO; ?>]</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>