<?php
/* @var $this ObjectController */
/* @var $model Object */

$this->breadcrumbs = array(
    'Устройства' => array('index'),
    $model->id,
);
?>

<?php $this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Настройки устройства",
));?>
<h3>Устройство: [<?php echo $model->IMEI; ?>]</h3>
<?php $this->renderPartial('form_start',array('model'=>$model))?>

<?php echo CHtml::link('[Редактировать]', $this->createUrl("/$this->id/update/$model->id"));?>
<br>
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
        'type' => 'condensed bordered striped', //striped bordered and/or condensed
	'attributes'=>array(
		'id',
		'IMEI',
		'deviceType.type_name',
		'soft_version',
		'object.obj',
                'comment',
                'ICCID',
                'phone',
                //'interval',
                //'zapros'
	),
)); ?>

<?php $this->endWidget()?>
