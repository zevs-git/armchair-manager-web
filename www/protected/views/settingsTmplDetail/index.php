<?php
$this->breadcrumbs=array(
	'Settings Tmpl Details',
);

$this->menu=array(
	array('label'=>'Create SettingsTmplDetail','url'=>array('create')),
	array('label'=>'Manage SettingsTmplDetail','url'=>array('admin')),
);
?>

<h1>Settings Tmpl Details</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
