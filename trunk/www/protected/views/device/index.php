<?php
$this->breadcrumbs=array(
	'Устройтсва',
);

$this->menu=array(
	array('label'=>'Управление устройствами','url'=>array('admin')),
);
?>

<h2>Устройства</h2>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
