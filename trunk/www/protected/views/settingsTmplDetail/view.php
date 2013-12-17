<?php if(!Yii::app()->request->isAjaxRequest): ?>
<?php
$this->breadcrumbs=array(
	'Settings Tmpl Details'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SettingsTmplDetail','url'=>array('index')),
	array('label'=>'Create SettingsTmplDetail','url'=>array('create')),
	array('label'=>'Update SettingsTmplDetail','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete SettingsTmplDetail','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SettingsTmplDetail','url'=>array('admin')),
);
?>

<h1>View SettingsTmplDetail #<?php echo $model->id; ?></h1>
<?php endif; ?>

<?php if(Yii::app()->request->isAjaxRequest): ?>
<div class="modal-header">
	<a class="close" data-dismiss="modal">&times;</a>
	<h4>View People #<?php echo $model->id; ?></h4>
</div>

<div class="modal-body">
<?php endif; ?>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tmpl_id',
		'var_id',
		'acc_lvl',
		'default',
	),
)); ?>

<?php if(Yii::app()->request->isAjaxRequest): ?>
</div>

<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Закрыть',
        'url'=>'#',
        'htmlOptions'=>array(
			'id'=>'btn-'.mt_rand(),
			'data-dismiss'=>'modal'
		),
    )); ?>
</div>

<?php endif; ?>