<?php
/* @var $this DeviceController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Устройства',
);

$this->menu=array(
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Управление', 'url'=>array('admin')),
);
?>

<h1>Устройства</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
