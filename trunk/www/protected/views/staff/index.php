<?php
/* @var $this StaffController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Staff',
);

/*$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Управление', 'url'=>array('admin')),
);*/
?>

<h1>Персонал</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
