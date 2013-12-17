<?php
$this->breadcrumbs=array(
	'Settings Templates',
);

$this->menu=array(
	array('label'=>'Create SettingsTemplate','url'=>array('create')),
	array('label'=>'Manage SettingsTemplate','url'=>array('admin')),
);
?>

<h1>Settings Templates</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
