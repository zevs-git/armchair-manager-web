<?php
/* @var $this StaffController */
/* @var $model Staff */

$this->breadcrumbs=array(
	'Персонал'=>array('index'),
	'Управление',
);

/*$this->menu=array(
	array('label'=>'Список', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#staff-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Управление персоналом</h3>


    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Добавить',
        'icon' => 'plus-sign',
        'type' => 'primary',
        'buttonType' => 'link',
        'url' => $this->createUrl('create'),
    ));
    ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'staff-grid',
	'dataProvider'=>$model->search(),
        'itemsCssClass' => 'table table-striped table-bordered',
	'filter'=>$model,
	'columns'=>array(
		'id',
		'FIO',
                array('name' => 'type_descr',
                'value' => '$data->type->descr'),
		'key',
		'phone',
		'comment',
		/*
		'object_id',
		*/
		array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'htmlOptions' => array('style' => 'min-width: 70px; text-align: center;'),
                'template' => '{view}{delete}',
                'buttons' => array(
                    'view' => array(
                        'label' => 'Настройки устройтва',
                        'icon' => 'icon-pencil',
                        //'url' => 'Yii::app()->createUrl("object/view", array("id"=>$data->id))',
                        'options' => array(
                            'class' => 'btn btn-small',
                        ),
                    ),
                    'delete' => array(
                        'options' => array(
                            //'url' => 'Yii::app()->createUrl("object/view", array("id"=>$data->id))',
                            'class' => 'btn btn-small delete',
                        ),
                    ),
                ),
            ),
	),
)); ?>
