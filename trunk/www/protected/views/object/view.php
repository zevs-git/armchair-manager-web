<?php
/* @var $this ObjectController */
/* @var $model Object */

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

<?php echo CHtml::link('[Редактировать]', $this->createUrl("/$this->id/update/$model->id"));?>
<br>
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
        'type' => 'condensed bordered striped', //striped bordered and/or condensed
	'attributes'=>array(
		//'id',
		'country',
		'region',
		'city',
		'street',
		'house',
		'type',
		'obj',
		'face',
		'phone',
		'comment',
	),
)); ?>

<?php $this->endWidget()?>
