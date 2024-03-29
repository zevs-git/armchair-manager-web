<?php
/* @var $this ObjectController */
/* @var $model Staff */
?>

<?php $this->widget('zii.widgets.grid.CGridView',array(
	'id'=>'staff-grid',
        'itemsCssClass' => 'table table-striped table-bordered',
	//'ajaxUpdate'=>true,
	'dataProvider'=>$model->search($staff_type),
	'filter'=>$model,
        //'ajaxUpdate'=>'modal-body',
        //'ajaxUrl' => array('object/GetStaffLis'),
    'columns'=>array(
		'id',
		'FIO',
		//'staff_type_id',
		//'key',
		//'phone',
		'comment',
		/*
		'object_id',
		*/
		array(
                'class'=>'CButtonColumn',
                'template' => "{insert}",
                'buttons' => array(
                    "insert" => array(
                        'label' => "выбрать",
                        'options' => array(
                            "class" => "btn btn-mini btn-success",
                            "onclick" => 'selectData("'. $field .'",$(this).parent().parent().children(":nth-child(1)").text(),$(this).parent().parent().children(":nth-child(2)").text());',
                        )
                    ),
                )
            ),
	),
    ));
?>