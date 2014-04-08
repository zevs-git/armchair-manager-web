<?php
/* @var $this DepartmentController */
/* @var $model Department */
?>
<?php
$this->breadcrumbs=array(
	'Дилеры'=>array('index'),
	$model->id,
);
?>

<?php $this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Праметры дилера",
));?>
<h3>Дилер: "<?php echo $model->name; ?>"</h3>
<?php $this->renderPartial('form_start',array('model'=>$model))?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->endWidget()?>