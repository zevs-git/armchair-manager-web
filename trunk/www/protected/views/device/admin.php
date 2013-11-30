<?php
/* @var $this DeviceController */
/* @var $model Device */

$this->breadcrumbs=array(
	'Устройства'=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#device-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управлените устрйствами</h1>

<p>
Вы можете дополнительно использовать операторы сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) в начале каждого из ваших значений поиска.
</p>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'device-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'itemsCssClass' => 'table table-striped',
	'columns'=>array(
		'id',
		'IMEI',
		'type_id',
		'group_id',
		'soft_version',
		'SIM',
		/*
		'object_id',
		'create_user_id',
		'create_date',
		'update_user_id',
		'update_date',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
