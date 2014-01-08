<?php
$this->breadcrumbs=array(
	'Devices'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
?>
<?php $this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Настрйоки устройства",
));?>
<h3>Устройство: [<?php echo $model->IMEI; ?>]</h3>
<?php $this->renderPartial('form_start',array('model'=>$model))?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->endWidget()?>