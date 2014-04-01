<?php
$this->breadcrumbs=array(
	'Departaments',
);

$this->menu=array(
	array('label'=>'Create Departament', 'url'=>array('create')),
	array('label'=>'Manage Departament', 'url'=>array('admin')),
);
?>

<h1>Departaments</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
