<?php
/* @var $this ObjectController */
/* @var $model Staff */
?>

<?php $this->widget('zii.widgets.grid.CGridView',array(
	'id'=>'staff-grid',
        'itemsCssClass' => 'table table-striped table-bordered',
	//'ajaxUpdate'=>true,
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        //'ajaxUpdate'=>'modal-body',
        //'ajaxUrl' => array('object/GetStaffLis'),
    'columns'=>array(
		'id',
		'IMEI',
		//'staff_type_id',
		//'key',
		//'phone',
		'comment',
		'object.obj',
		array(
                'class'=>'CButtonColumn',
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