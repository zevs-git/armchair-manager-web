<?php
/* @var $model SettingsTmplDetail */

$this->breadcrumbs = array(
    'Settings Tmpl Details' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List SettingsTmplDetail', 'url' => array('index')),
    array('label' => 'Create SettingsTmplDetail', 'url' => array('create'), 'linkOptions' => array(
            'ajax' => array(
                'url' => $this->createUrl('create'),
                'success' => 'function(r){$("#TBDialogCrud").html(r).modal("show");}',
            ),
        )),
);
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'TBDialogCrud')); ?>
<?php $this->endWidget(); ?>

<h2>Управление переменными шаблона</h2>

<div class="btn-toolbar">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Добавить переменную',
        'icon'=>'plus-sign',
        'type' => 'primary',
        'buttonType' => 'ajaxLink',
        'url' => $this->createUrl('create') . "/$tmpl_id",
        'ajaxOptions' => array(
            'url' => $this->createUrl('create'),
            'success' => 'function(r){$("#TBDialogCrud").html(r).modal("show");}'
        )
    ));
    
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => 'Очистить шаблон',
        'icon'=>'minus-sign',
        'type' => 'danger',
        'buttonType' => 'ajaxLink',
        'url' => $this->createUrl('deleteAll'). "/$tmpl_id",
        'ajaxOptions' => array(
            'url' => $this->createUrl('deleteAll'),
            'success' => 'function(r){window.location.reload()}'
        )
    ));
    ?>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'settings-tmpl-detail-grid',
    'itemsCssClass' => 'table table-striped table-bordered',
    //'ajaxUpdate' => true,
    'dataProvider' => $model->search_tmpl($tmpl_id),
    //'filter' => $model,
    'columns' => array(
        array('name'=>'var_id',
            'header'=>'Номер'),
        array('name'=>'var_id',
            'value'=>'$data->var->descr'),
        'acc_lvl_val',
        'default',
        array(
            'class' => 'myButtonColumn',
            'viewButtonVisible' => 'FALSE',
            'buttons' => array(
                'update' => array(
                    'click' => 'function(){
						var url = $(this).attr("href");
						$.get(url, function(r){
							$("#TBDialogCrud").html(r).modal("show");
						});
						return false;
					}',
                ),
                'delete' => array(
                    'click' => 'function(){
						var url = $(this).attr("href");
						$.get(url).always( function(){
							$.fn.yiiGridView.update("settings-tmpl-detail-grid");
						});
						return false;
					}',
                ),
            ),
        ),
    ),
));

$this->widget('bootstrap.widgets.TbButton', array(
    'label' => 'Ок',
    'icon'=>'ok',
    'type' => 'success',
    'url' => $this->createUrl('/settingsTemplate/admin'),
));
?>
