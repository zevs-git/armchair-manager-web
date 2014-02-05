<?php
/* @var $this ObjectController */
/* @var $model Object */

$this->breadcrumbs = array(
    'Объекты' => array('index'),
    'Управление',
);

$this->menu = array(
    array('label' => 'Объекты', 'url' => array('index'), 'active' => true),
    array('label' => 'Добавить', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#object-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Управление объектами</h3>

<?php echo CHtml::link('Расширенный поиск', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->


<div class="btn-toolbar">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Новый объект',
        'icon' => 'plus-sign',
        'type' => 'primary',
        'buttonType' => 'link',
        'url' => $this->createUrl('create'),
    ));
    ?>
</div>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'object-grid',
    'itemsCssClass' => 'table table-striped table-bordered',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array('name' => 'id', 'htmlOptions' => array('style' => 'width: 40px;')),
        'country',
        'region',
        'city',
        //'street',
//'house',
//'type',
        'obj',
        //'face',
//'phone',
//'comment',
        array('class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {delete}',
            'buttons' => array(
                'view' => array(
                    'label' => 'Настройки объекта',
                    'icon' => 'icon-pencil',
                    'data_id'=>'$data->id',
                    'url' => 'Yii::app()->createUrl("object/view", array("id"=>$data->id))',
                    'options'=>array(
                        'class'=>'btn btn-small',
                    ),
                ),
                'delete' => array(
                    //'url' => 'Yii::app()->createUrl("object/view", array("id"=>$data->id))',
                    'options'=>array(
                        'class'=>'btn btn-small delete',
                    ),
                ),
            ),
        ),
    ),
));
?>
<script>
    $('.delete').click(function() {
        if ($(this).attr("href").replace(/.*delete\//, "") == 0) {
            alert('Нельзя удалить базовый объект');
            return false;
        }
        return true;
    });
</script>
