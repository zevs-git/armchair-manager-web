<?php
$this->breadcrumbs=array(
	'Дилеры'=>array('index'),
	$model->name,
);
?>

<?php $this->beginWidget('zii.widgets.CPortlet', array(
    'title' => "Прамаетры дилера",
));?>

<h3>Дилер: "<?php echo $model->name; ?>"</h3>
<?php $this->renderPartial('form_start',array('model'=>$model))?>
<?php echo CHtml::link('[Редактировать]', $this->createUrl("/$this->id/update/$model->id"));?>
<br>
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
        'type' => 'condensed bordered striped', //striped bordered and/or condensed
	'attributes'=>array(
		'id',
		'name',
		'country',
                'region',
                'city',
                'fname',
            'mname',
            'phone',
            'email',
            'comment',
	),
)); ?>
<?php $this->endWidget()?>
