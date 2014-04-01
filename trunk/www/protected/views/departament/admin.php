<?php
$this->breadcrumbs=array(
	'Departaments'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Departament', 'url'=>array('index')),
	array('label'=>'Create Departament', 'url'=>array('create'), 'linkOptions'=>array(
		'ajax' => array(
			'url'=>$this->createUrl('create'),
			'success'=>'js:function(r){$("#DialogCRUDForm").html(r).dialog("option", "title", "Create Departament").dialog("open"); return false;}',
		),
	)),
);

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
        'id'=>'DialogCRUDForm',
        'options'=>array(
			'autoOpen'=>false,
			'modal'=>true,
			'width'=>'auto',
			'height'=>'auto',
			'resizable'=>'false',
		),
	));
$this->endWidget();

$updateDialog =<<<'EOT'
function() {
	var url = $(this).attr('href');
    $.get(url, function(r){
        $("#update").html(r).dialog("open");
		$("#DialogCRUDForm").html(r).dialog("option", "title", "Update Departament").dialog("open");
    });
    return false;
}
EOT;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('departament-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>Управление департаментами</h3>


<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<div class="btn-toolbar">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Новый департамент',
        'icon' => 'plus-sign',
        'type' => 'primary',
        'buttonType' => 'ajaxLink',
        'url' => $this->createUrl('create'),
        'ajaxOptions' => array(
			'url'=>$this->createUrl('create'),
			'success'=>'js:function(r){$("#DialogCRUDForm").html(r).dialog("option", "title", "Create Departament").dialog("open"); return false;}',
		),
    ));
    ?>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'departament-grid',
	'ajaxUpdate'=>false,
        'itemsCssClass' => 'table table-striped table-bordered',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'comment',
		array(
			'class'=>'CButtonColumn',
			'buttons' => array(
				'update' => array(
					'click'=>$updateDialog
				),
			), 
		),
	),
)); ?>
