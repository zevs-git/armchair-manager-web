<?php

/* @var $this ObjectController */
/* @var $model Device */
?>

<?php

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'device-grid-modal',
    'itemsCssClass' => 'table table-striped table-bordered',
    //'ajaxUpdate'=>true,
    'dataProvider' => $model->search(),
    'filter' => $model,
    //'ajaxUpdate'=>'modal-body',
    //'ajaxUrl' => array('object/GetStaffLis'),
    'columns' => array(
        'id',
        'IMEI',
        'comment',
        'object.obj',
        array(
            'class' => 'CButtonColumn',
            'template' => "{insert}",
            'buttons' => array(
                "insert" => array(
                    'label' => "выбрать",
                    'options' => array(
                        "class" => "btn btn-mini btn-success",
                        "onclick" => 'selectData($(this).parent().parent().children(":nth-child(1)").text());',
                    )
                ),
            )
        ),
    ),
));
?>