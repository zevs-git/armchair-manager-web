<?php if (!Yii::app()->request->isAjaxRequest): ?>

<?php
$this->breadcrumbs=array(
	'Дилеры'=>array('index'),
	'Новый дилер',
);

$this->menu=array(
	array('label'=>'List Departament', 'url'=>array('index')),
	array('label'=>'Manage Departament', 'url'=>array('admin')),
);
?>

<h1>Новый дилер</h1>

<?php endif; ?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>