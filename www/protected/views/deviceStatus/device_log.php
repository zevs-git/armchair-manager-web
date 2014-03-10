<?php $this->widget('zii.widgets.grid.CGridView',array(
	'id'=>'staff-grid',
        'itemsCssClass' => 'table table-striped table-bordered',
        'htmlOptions' => array('class'=>'no-summay','style' => 'text-align: center;font-size: 12px;'),
	'dataProvider'=>$model->search($id),
        'rowCssClassExpression'=>'$data->rowClass',
	//'filter'=>$model,
    'columns'=>array(
                array('name'=>'type',
                       'header'=>'',
                       'type'=>'raw',
                       'htmlOptions'=>array('style' => 'width: 10px; padding: 0px;')
                ),
		array('name'=>'dt','htmlOptions'=>array('style' => 'padding: 0px;')
                ),
                array('name'=>'message.descr',
                      'htmlOptions'=>array('style' => 'text-align: left; padding: 0px;')
                ),
	),
    ));
?>