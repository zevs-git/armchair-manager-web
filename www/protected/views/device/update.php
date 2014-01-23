<?php
$this->breadcrumbs=array(
	'Устрйоства'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Реадактировать',
);
?>
<?php $this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Настройки устройства",
));?>
<h3>Устройство: [<?php echo $model->IMEI; ?>]</h3>
<?php $this->renderPartial('form_start',array('model'=>$model))?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>

<?php $this->endWidget()?>