<?php
/* @var $this StaffController */
/* @var $model Staff */

$this->breadcrumbs=array(
	'Персонал'=>array('index'),
	$model->FIO,
);

/*$this->menu=array(
	array('label'=>'Список песонала', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Редактировать', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление персоналом', 'url'=>array('admin')),
);*/
?>

<h1><?php echo $model->FIO; ?></h1>
<?php echo CHtml::link('[Редактировать]', $this->createUrl("/$this->id/update/$model->id"));?>
<br>
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'FIO',
		'staff_type_id',
		'key',
		'phone',
		'comment',
		//'object_id',
	),
)); ?>
