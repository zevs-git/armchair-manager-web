<?php
/* @var $this ObjectController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Объекты',
);

$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Объекты</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
