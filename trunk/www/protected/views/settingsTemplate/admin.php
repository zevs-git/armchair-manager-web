<?php
$this->breadcrumbs = array(
    'Шаблоны настроек',
);

$this->menu = array(
    array('label' => 'Шаблоны настроек', 'url' => array('admin')),
);
?>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'TBDialogCrud')); ?>
<?php $this->endWidget(); ?>

<h2>Управление шаблонами настроек</h2>

<div class="btn-toolbar">
    <?php
    $this->widget('bootstrap.widgets.TbButtonGroup', array(
        'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'buttons' => array(
            array('label' => 'Создать шаблон',
                'buttonType' => 'ajaxLink',
                'url' => $this->createUrl('create'),
                'ajaxOptions' => array(
                    'url' => $this->createUrl('create'),
                    'success' => 'function(r){$("#TBDialogCrud").html(r).modal("show");}',
                ),
            ),
        ),
    ));
    ?>
</div>
<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'settings-template-grid',
    'itemsCssClass' => 'table table-striped table-bordered',
    'ajaxUpdate' => true,
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'id',
        'descr',
        array('class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} {delete}',
            'buttons' => array(
                'view' => array(
                    'label' => 'Редактировать шаблон',
                    'icon' => 'icon-pencil',
                    'url' => 'Yii::app()->createUrl("settingsTmplDetail/ServiceSettings", array("id"=>$data->id))',
                    'options' => array(
                        'class' => 'btn btn-small',
                    ),
                ),
                'delete' => array(
                    'options' => array(
                        'url' => 'Yii::app()->createUrl("object/view", array("id"=>$data->id))',
                        'class' => 'btn btn-small delete',
                    ),
                    'click' => 'function(){
						var url = $(this).attr("href");
						$.get(url).always( function(){
							$.fn.yiiGridView.update("settings-template-grid");
						});
						return false;
					}',
                ),
            ),
        ),
    ),
));
?>
