<?php
/* @var $this ObjectController */
/* @var $model Object */
?>
<?php
$this->breadcrumbs=array(
	'Объекты'=>array('index'),
	$model->id,
);
?>

<?php $this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Настройка объекта",
));?>
<h3>Объект: "<?php echo $model->obj; ?>"</h3>
<?php $this->renderPartial('form_start',array('model'=>$model))?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->endWidget()?>