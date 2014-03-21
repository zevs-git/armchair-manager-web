<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'staff-grid',
    'itemsCssClass' => 'table table-striped table-bordered',
    'htmlOptions' => array('class' => 'no-summay', 'style' => 'text-align: center;font-size: 12px; margin: -30px; margin-top: -50px;'),
    'dataProvider' => $model->search($id),
    'rowCssClassExpression' => '$data->rowClass',
    //'filter'=>$model,
    'columns' => array(
        array('name' => 'dt',
            'htmlOptions' => array('style' => 'padding: 0px;')
        ),
        array(
            'name' => 'device_id',
            'value' => '"[" . $data->device_id . "] " . $data->device->comment',
            'htmlOptions' => array('style' => 'padding: 0px;')
        ),
        array('name' => 'message.descr',
            'htmlOptions' => array('style' => 'padding: 0px;')
        ),
        /*array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{ok}{delete}',
            'htmlOptions' => array('style' => 'padding: 0px; text-align: center;'),
            'buttons' => array(
                'ok' => array(
                    'icon' => 'icon-ok',
                    'options' => array(
                        //'url' => 'Yii::app()->createUrl("object/view", array("id"=>$data->id))',
                        'class' => 'btn btn-mini icon-ok',
                    ),
                ),
                'delete' => array(
                    'label' => 'Настройки устройтва',
                    'url' => 'Yii::app()->createUrl("SettingsDeviceDetail",array("admin"=>$data->id))',
                    'icon' => 'icon-remove',
                    'click' => 'function(){
						var url = $(this).attr("href");
                                                document.location = url;
						return false;
					}',
                    'options' => array(
                        'class' => 'btn btn-mini icon-remove',
                    ),
                ),
            ),
        ),*/
    ),
));
?>