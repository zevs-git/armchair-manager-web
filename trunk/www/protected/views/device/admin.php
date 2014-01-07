<?php
$this->breadcrumbs=array(
	'Устройcтва'=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Список устройств','url'=>array('index')),
	array('label'=>'Создать устройтво', 'url'=>array('create'), 'linkOptions'=>array(
		'ajax' => array(
			'url'=>$this->createUrl('create'),
			'success'=>'function(r){$("#TBDialogCrud").html(r).modal("show");}', 
		),
	)),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('device-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'TBDialogCrud')); ?>
<?php $this->endWidget(); ?>

<h2>Управление устройствами</h2>
<!-- 
<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>search-form -->

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'device-grid',
        'itemsCssClass' => 'table table-striped table-bordered',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'IMEI',
                'soft_version',
		'deviceType.type_name',
		'object.obj',
                'comment',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                        'template'=>'{view}{update}{delete}{settings}',
			'buttons' => array(
				'update' => array(
					'click'=>'function(){
						var url = $(this).attr("href");
						$.get(url, function(r){
							$("#TBDialogCrud").html(r).modal("show");
						});
						return false;
					}',
				),
				'view' => array(
					'click'=>'function(){
						var url = $(this).attr("href");
						$.get(url, function(r){
							$("#TBDialogCrud").html(r).modal("show");
						});
						return false;
					}',
				),
                                'settings' => array(
                                        'label'=>'Настройки устройтва',
                                        'url'=>'Yii::app()->createUrl("SettingsDeviceDetail",array("admin"=>$data->id))',
                                        'icon'=>'icon-cog',
                                        'click'=>'function(){
						var url = $(this).attr("href");
                                                document.location = url;
						return false;
					}',
				),
			),
		),
	),
)); ?>
