<?php if (!Yii::app()->request->isAjaxRequest): ?>

<?php
$this->breadcrumbs=array(
	'Departaments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Departament', 'url'=>array('index')),
	array('label'=>'Manage Departament', 'url'=>array('admin')),
);
?>

<h1>Create Departament</h1>

<?php endif; ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>