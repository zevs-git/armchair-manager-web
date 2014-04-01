<?php if (!Yii::app()->request->isAjaxRequest): ?>

<?php
$this->breadcrumbs=array(
	'Departaments'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Departament', 'url'=>array('index')),
	array('label'=>'Create Departament', 'url'=>array('create')),
	array('label'=>'View Departament', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Departament', 'url'=>array('admin')),
);
?>

<h1>Update Departament <?php echo $model->id; ?></h1>

<?php endif; ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>